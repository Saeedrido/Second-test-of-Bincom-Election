<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PollingUnitRepository;

class PollingUnitController extends Controller
{
    public function __construct(
        protected PollingUnitRepository $pollingUnitRepository
    ) {}

    public function index($wardId)
    {
        $pollingUnits = $this->pollingUnitRepository->getByWard($wardId);

        return response()->json($pollingUnits);
    }
}

