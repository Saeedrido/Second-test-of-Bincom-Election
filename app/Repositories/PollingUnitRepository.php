<?php

namespace App\Repositories;

use App\Models\PollingUnit;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PollingUnitRepository
{
    public function __construct(
        protected PollingUnit $model
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['ward', 'lga'])
            ->where('uniquewardid', '>', 0)
            ->where('lga_id', '>', 0)
            ->paginate($perPage);
    }

    public function findById(int $id): PollingUnit
    {
        $unit = $this->model
            ->with(['ward', 'lga.state', 'results', 'results.party'])
            ->find($id);

        if (!$unit) {
            throw new ModelNotFoundException("Polling unit not found.");
        }

        return $unit;
    }

    public function search(string $query): Collection
    {
        return $this->model
            ->with(['ward', 'lga'])
            ->where('uniquewardid', '>', 0)
            ->where('lga_id', '>', 0)
            ->where(function ($q) use ($query) {
                $q->where('polling_unit_name', 'like', "%{$query}%")
                  ->orWhere('polling_unit_number', 'like', "%{$query}%");
            })
            ->get();
    }

    public function getByWard(int $wardId): Collection
    {
        return $this->model
            ->where('uniquewardid', $wardId)
            ->get();
    }

    public function getByLga(int $lgaId): Collection
    {
        return $this->model
            ->with('ward')
            ->where('lga_id', $lgaId)
            ->get();
    }

    public function getValidUnits(): Collection
    {
        return $this->model
            ->with(['ward', 'lga'])
            ->where('uniquewardid', '>', 0)
            ->where('lga_id', '>', 0)
            ->orderBy('polling_unit_name')
            ->get();
    }
}
