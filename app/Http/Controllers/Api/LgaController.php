<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\StateRepository;

class LgaController extends Controller
{
    public function __construct(
        protected StateRepository $stateRepository
    ) {}

    public function index($stateId)
    {
        $lgas = $this->stateRepository->getLgas($stateId);

        return response()->json($lgas);
    }
}

