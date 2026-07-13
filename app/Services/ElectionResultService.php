<?php

namespace App\Services;

use App\Models\Lga;
use App\Models\PollingUnit;
use App\Models\Ward;
use App\Repositories\ElectionResultRepository;
use App\Repositories\PartyRepository;

class ElectionResultService
{
    protected array $chartColors = [
        '#3B82F6',
        '#EF4444',
        '#10B981',
        '#F59E0B',
        '#8B5CF6',
        '#EC4899',
        '#06B6D4',
        '#F97316',
        '#6366F1',
    ];

    protected array $abbreviationOverrides = [
        'LABO' => 'LABOUR',
    ];

    public function __construct(
        protected ElectionResultRepository $resultRepo,
        protected PartyRepository $partyRepo,
    ) {}

    public function getPollingUnitResults(int $pollingUnitId): array
    {
        $pollingUnit = PollingUnit::with(['ward', 'lga.state'])
            ->where('uniquewardid', '>', 0)
            ->where('lga_id', '>', 0)
            ->find($pollingUnitId);

        if (!$pollingUnit) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Polling unit not found.');
        }

        $results = $this->resultRepo->getResultsForPollingUnit($pollingUnitId);
        $partyMap = $this->buildPartyMap();

        $formattedResults = $results->map(function ($result) use ($partyMap) {
            $abbreviation = $result->party_abbreviation;

            return [
                'party_abbreviation' => $abbreviation,
                'party_name' => $partyMap[$abbreviation] ?? $abbreviation,
                'party_score' => $result->party_score,
            ];
        })->sortByDesc('party_score')->values()->toArray();

        $totalVotes = array_sum(array_column($formattedResults, 'party_score'));
        $winner = $formattedResults[0] ?? null;

        return [
            'results' => $formattedResults,
            'total_votes' => $totalVotes,
            'winner' => $winner,
            'polling_unit' => $pollingUnit,
        ];
    }

    public function getLgaAggregatedResults(int $lgaId): array
    {
        $lga = Lga::with('state')->find($lgaId);

        if (!$lga) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('LGA not found.');
        }

        $aggregated = $this->resultRepo->getAggregatedLgaResults($lgaId);
        $partyMap = $this->buildPartyMap();

        $results = $aggregated->map(function ($row) use ($partyMap) {
            $abbreviation = $row->party_abbreviation;

            return [
                'party_abbreviation' => $abbreviation,
                'party_name' => $partyMap[$abbreviation] ?? $abbreviation,
                'total_score' => (int) $row->total_score,
            ];
        })->sortByDesc('total_score')->values()->toArray();

        $totalVotes = array_sum(array_column($results, 'total_score'));
        $winner = $results[0] ?? null;
        $runnerUp = $results[1] ?? null;
        $margin = $winner && $runnerUp
            ? $winner['total_score'] - $runnerUp['total_score']
            : 0;

        $pollingUnitCount = PollingUnit::where('lga_id', $lgaId)
            ->where('uniquewardid', '>', 0)
            ->count();

        return [
            'results' => $results,
            'total_votes' => $totalVotes,
            'winner' => $winner,
            'runner_up' => $runnerUp,
            'margin' => $margin,
            'lga' => $lga,
            'polling_unit_count' => $pollingUnitCount,
        ];
    }

    public function formatResultsForChart(array $results): array
    {
        $scoreKey = array_key_exists('party_score', $results[0] ?? [])
            ? 'party_score'
            : 'total_score';

        return [
            'labels' => array_column($results, 'party_name'),
            'data' => array_column($results, $scoreKey),
            'colors' => array_map(
                fn (int $i) => $this->chartColors[$i % count($this->chartColors)],
                range(0, count($results) - 1)
            ),
        ];
    }

    public function storePollingUnitResults(array $validatedData): bool
    {
        $pollingUnitId = (int) $validatedData['polling_unit_uniqueid'];

        if ($this->resultRepo->hasResults($pollingUnitId)) {
            throw new \RuntimeException('Results already exist for this polling unit.');
        }

        return $this->resultRepo->storeResults($pollingUnitId, $validatedData['results']);
    }

    public function getDashboardStats(): array
    {
        $parties = $this->partyRepo->getAll();
        $recentResults = $this->resultRepo->getRecentResults(5);
        $topParties = $this->resultRepo->getPartyTotals()->take(5);

        return [
            'total_polling_units' => PollingUnit::where('uniquewardid', '>', 0)
                ->where('lga_id', '>', 0)
                ->count(),
            'total_lgas' => Lga::count(),
            'total_wards' => Ward::where('lga_id', '>', 0)->count(),
            'total_parties' => $parties->count(),
            'recent_results' => $recentResults,
            'top_parties' => $topParties,
        ];
    }

    protected function buildPartyMap(): array
    {
        $map = $this->partyRepo->getAll()->mapWithKeys(
            fn ($party) => [$party->partyid => $party->partyname]
        )->toArray();

        foreach ($this->abbreviationOverrides as $from => $to) {
            if (isset($map[$to])) {
                $map[$from] = $map[$to];
            }
        }

        return $map;
    }
}
