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

        return view('dashboard', compact('stats'));
    }
}
