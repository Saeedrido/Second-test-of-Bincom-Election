<?php

namespace App\Repositories;

use App\Models\Ward;
use Illuminate\Database\Eloquent\Collection;

class WardRepository
{
    public function __construct(
        protected Ward $model
    ) {}

    public function getByLga(int $lgaId): Collection
    {
        return $this->model->withCount('pollingUnits')
            ->where('lga_id', $lgaId)
            ->get();
    }

    public function findById(int $id): ?Ward
    {
        return $this->model->with(['lga', 'lga.state'])->find($id);
    }
}
