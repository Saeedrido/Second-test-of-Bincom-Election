<?php

namespace App\Http\Controllers;

use App\Repositories\PollingUnitRepository;
use App\Services\ElectionResultService;

class PollingUnitController extends Controller
{
    public function __construct(
        protected ElectionResultService $resultService,
        protected PollingUnitRepository $pollingUnitRepository
    ) {}

    public function index()
    {
        $search = request('query');

        $pollingUnits = $search
            ? $this->pollingUnitRepository->search($search)
            : $this->pollingUnitRepository->getAll();

        return view('polling-units.index', compact('pollingUnits', 'search'));
    }

    public function show($id)
    {
        $data = $this->resultService->getPollingUnitResults((int) $id);

        return view('polling-units.show', $data);
    }
}
