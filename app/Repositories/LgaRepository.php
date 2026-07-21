<?php

namespace App\Repositories;

use App\Models\Lga;
use Illuminate\Database\Eloquent\Collection;

class LgaRepository
{
    public function __construct(
        protected Lga $model
    ) {}

    public function getAll(): Collection
    {
        return $this->model->with('state')->get();
    }

    public function findById(int $id): ?Lga
    {
        return $this->model->with('state')->find($id);
    }

    public function getByState(int $stateId): Collection
    {
        return $this->model->where('state_id', $stateId)->get();
    }

    public function getWards(int $lgaId): Collection
    {
        return $this->model->find($lgaId)?->wards ?? collect();
    }
}

