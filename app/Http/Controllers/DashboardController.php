<?php

namespace App\Http\Controllers;

use App\Services\ElectionResultService;

class DashboardController extends Controller
{
    public function __construct(
        protected ElectionResultService $resultService
    ) {}

    public function index()
    {
        $stats = $this->resultService->getDashboardStats();

        return view('dashboard', [
            'stats' => $stats,
            'meta' => [
                'title' => 'Dashboard',
                'description' => 'Overview of election results across all polling units',
            ],
        ]);
    }
}
