<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePollingUnitResultRequest;
use App\Repositories\PartyRepository;
use App\Repositories\StateRepository;
use App\Services\ElectionResultService;

class ResultController extends Controller
{
    public function __construct(
        protected StateRepository $stateRepository,
        protected PartyRepository $partyRepository,
        protected ElectionResultService $resultService
    ) {}

    public function create()
    {
        $states = $this->stateRepository->getAll();
        $parties = $this->partyRepository->getAll();

        return view('results.create', compact('states', 'parties'));
    }

    public function store(StorePollingUnitResultRequest $request)
    {
        $results = collect($request->results)->map(fn ($r) => [
            'party_abbreviation' => $r['party_abbreviation'],
            'party_score' => $r['party_score'],
            'entered_by_user' => $request->user()?->name ?? 'Anonymous',
            'user_ip_address' => $request->ip(),
        ])->toArray();

        try {
            $this->resultService->storePollingUnitResults([
                'polling_unit_uniqueid' => $request->polling_unit_uniqueid,
                'results' => $results,
            ]);

            return redirect()
                ->route('results.create')
                ->with('success', 'Polling unit results have been recorded successfully.');
        } catch (\RuntimeException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}

