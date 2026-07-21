<?php

namespace App\Services;

use App\Models\Lga;
use App\Models\PollingUnit;
use App\Models\Ward;
use App\Repositories\ElectionResultRepository;
use App\Repositories\LgaRepository;
use App\Repositories\PartyRepository;

class StatisticsService
{
    protected array $abbreviationOverrides = [
        'LABO' => 'LABOUR',
    ];

    public function __construct(
        protected ElectionResultRepository $resultRepo,
        protected LgaRepository $lgaRepo,
        protected PartyRepository $partyRepo,
    ) {}

    public function getOverviewStats(): array
    {
        $partyTotals = $this->resultRepo->getPartyTotals();

        return [
            'total_polling_units' => PollingUnit::where('uniquewardid', '>', 0)
                ->where('lga_id', '>', 0)
                ->count(),
            'total_lgas' => Lga::count(),
            'total_wards' => Ward::where('lga_id', '>', 0)->count(),
            'total_parties' => $this->partyRepo->getAll()->count(),
            'total_votes_cast' => $partyTotals->sum('total_score'),
            'recent_activity' => $this->resultRepo->getRecentResults(5),
        ];
    }

    public function getPartyPerformance(): array
    {
        $partyTotals = $this->resultRepo->getPartyTotals();
        $partyMap = $this->buildPartyMap();
        $grandTotal = $partyTotals->sum('total_score');

        return $partyTotals->map(function ($row) use ($partyMap, $grandTotal) {
            $abbreviation = $row->party_id;

            return [
                'party_abbreviation' => $abbreviation,
                'party_name' => $partyMap[$abbreviation] ?? $abbreviation,
                'total_score' => (int) $row->total_score,
                'percentage' => $grandTotal > 0
                    ? round(($row->total_score / $grandTotal) * 100, 2)
                    : 0.0,
            ];
        })->toArray();
    }

    public function getLgaPerformance(): array
    {
        $lgas = $this->lgaRepo->getAll();
        $partyMap = $this->buildPartyMap();

        return $lgas->map(function ($lga) use ($partyMap) {
            $aggregated = $this->resultRepo->getAggregatedLgaResults($lga->uniqueid)
                ->sortByDesc('total_score');

            $totalVotes = $aggregated->sum('total_score');
            $winner = $aggregated->first();
            $pollingUnitCount = PollingUnit::where('lga_id', $lga->uniqueid)
                ->where('uniquewardid', '>', 0)
                ->count();

            return [
                'lga_id' => $lga->uniqueid,
                'lga_name' => $lga->lga_name,
                'total_votes' => $totalVotes,
                'winner' => $winner ? [
                    'party_abbreviation' => $winner->party_id,
                    'party_name' => $partyMap[$winner->party_id] ?? $winner->party_id,
                    'total_score' => (int) $winner->total_score,
                    'percentage' => $totalVotes > 0 ? round(($winner->total_score / $totalVotes) * 100, 1) : 0,
                ] : null,
                'polling_unit_count' => $pollingUnitCount,
            ];
        })->toArray();
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
