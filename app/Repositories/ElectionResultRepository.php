<?php

namespace App\Repositories;

use App\Models\AnnouncedPuResult;
use App\Models\Party;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ElectionResultRepository
{
    protected array $abbreviationMap = [
        'LABO' => 'LABOUR',
    ];

    public function __construct(
        protected AnnouncedPuResult $model
    ) {}

    public function getResultsForPollingUnit(int $puId): Collection
    {
        return $this->model
            ->with('party')
            ->where('polling_unit_uniqueid', $puId)
            ->get();
    }

    public function getAggregatedLgaResults(int $lgaId): Collection
    {
        return $this->model
            ->select('party_abbreviation', DB::raw('SUM(party_score) as total_score'))
            ->whereIn('polling_unit_uniqueid', function ($query) use ($lgaId) {
                $query->select('uniqueid')
                    ->from('polling_unit')
                    ->where('lga_id', $lgaId)
                    ->where('uniquewardid', '>', 0);
            })
            ->groupBy('party_abbreviation')
            ->get()
            ->map(function ($row) {
                $row->party_id = $this->abbreviationMap[$row->party_abbreviation] ?? $row->party_abbreviation;
                return $row;
            });
    }

    public function getPartyTotals(): Collection
    {
        return $this->model
            ->select('party_abbreviation', DB::raw('SUM(party_score) as total_score'))
            ->groupBy('party_abbreviation')
            ->orderByDesc('total_score')
            ->get()
            ->map(function ($row) {
                $row->party_id = $this->abbreviationMap[$row->party_abbreviation] ?? $row->party_abbreviation;
                $party = Party::where('partyid', $row->party_id)->first();
                $row->party_name = $party->partyname ?? $row->party_id;
                return $row;
            });
    }

    public function hasResults(int $puId): bool
    {
        return $this->model
            ->where('polling_unit_uniqueid', $puId)
            ->exists();
    }

    public function storeResults(int $puId, array $results): bool
    {
        return DB::transaction(function () use ($puId, $results) {
            foreach ($results as $result) {
                $this->model->create([
                    'polling_unit_uniqueid' => (string) $puId,
                    'party_abbreviation' => $result['party_abbreviation'],
                    'party_score' => $result['party_score'],
                    'entered_by_user' => $result['entered_by_user'] ?? '',
                    'date_entered' => now(),
                    'user_ip_address' => $result['user_ip_address'] ?? request()->ip(),
                ]);
            }

            return true;
        }) ?? false;
    }

    public function getRecentResults(int $limit = 10): Collection
    {
        $recentPUs = $this->model
            ->select('polling_unit_uniqueid', DB::raw('MAX(date_entered) as latest_entry'))
            ->groupBy('polling_unit_uniqueid')
            ->orderByDesc('latest_entry')
            ->limit($limit)
            ->get();

        $puIds = $recentPUs->pluck('polling_unit_uniqueid')->map(fn ($id) => (int) $id)->values();

        $puMap = \App\Models\PollingUnit::with(['ward', 'lga'])
            ->whereIn('uniqueid', $puIds)
            ->get()
            ->keyBy('uniqueid');

        $resultsMap = $this->model
            ->with('party')
            ->whereIn('polling_unit_uniqueid', $puIds)
            ->get()
            ->groupBy('polling_unit_uniqueid');

        return $recentPUs->map(function ($row) use ($puMap, $resultsMap) {
            $row->polling_unit = $puMap->get((int) $row->polling_unit_uniqueid);
            $row->results = $resultsMap->get($row->polling_unit_uniqueid, collect());
            return $row;
        });
    }
}

