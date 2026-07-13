<?php

namespace App\Repositories;

use App\Models\Party;
use Illuminate\Support\Collection;

class PartyRepository
{
    public function __construct(
        protected Party $model
    ) {}

    public function getAll(): Collection
    {
        return $this->model->orderBy('partyid')->get();
    }
}
