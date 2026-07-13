<?php

namespace App\Repositories;

use App\Models\State;
use Illuminate\Database\Eloquent\Collection;

class StateRepository
{
    public function __construct(
        protected State $model
    ) {}

    public function getAll(): Collection
    {
        return $this->model->orderBy('state_name')->get();
    }

    public function getLgas(int $stateId): Collection
    {
        return $this->model->find($stateId)?->lgas ?? collect();
    }
}
