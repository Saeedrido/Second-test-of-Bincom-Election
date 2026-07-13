<?php

namespace App\Http\Controllers;

use App\Repositories\LgaRepository;
use App\Services\ElectionResultService;
use Illuminate\Http\Request;

class LgaController extends Controller
{
    public function __construct(
        protected LgaRepository $lgaRepository,
        protected ElectionResultService $resultService
    ) {}

    public function index()
    {
        $lgas = $this->lgaRepository->getAll();

        return view('lga.index', compact('lgas'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'lga_id' => 'required|integer|exists:lga,uniqueid',
        ]);

        $data = $this->resultService->getLgaAggregatedResults((int) $request->lga_id);

        return view('lga.results', $data);
    }
}
