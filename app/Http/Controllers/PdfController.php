<?php

namespace App\Http\Controllers;

use App\Models\PollingUnit;
use App\Models\Lga;
use App\Services\ElectionResultService;

class PdfController extends Controller
{
    public function __construct(
        protected ElectionResultService $resultService
    ) {}

    public function pollingUnit(int $id)
    {
        $data = $this->resultService->getPollingUnitResults($id);
        
        return view('pdf.polling-unit', $data);
    }

    public function lgaResults(int $lgaId)
    {
        $data = $this->resultService->getLgaAggregatedResults($lgaId);
        
        return view('pdf.lga-results', $data);
    }

    public function dashboard()
    {
        $stats = $this->resultService->getDashboardStats();
        
        return view('pdf.dashboard', ['stats' => $stats]);
    }
}