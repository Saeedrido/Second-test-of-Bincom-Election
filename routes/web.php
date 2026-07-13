<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LgaController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PollingUnitController;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/polling-units', [PollingUnitController::class, 'index'])->name('polling-units.index');
Route::get('/polling-units/{id}', [PollingUnitController::class, 'show'])->name('polling-units.show');

Route::get('/lga-results', [LgaController::class, 'index'])->name('lga.index');
Route::post('/lga-results/calculate', [LgaController::class, 'calculate'])->name('lga.calculate');

Route::get('/results/create', [ResultController::class, 'create'])->name('results.create');
Route::post('/results', [ResultController::class, 'store'])->name('results.store');

// PDF Export Routes
Route::get('/pdf/polling-unit/{id}', [PdfController::class, 'pollingUnit'])->name('pdf.polling-unit');
Route::get('/pdf/lga/{lgaId}', [PdfController::class, 'lgaResults'])->name('pdf.lga');
Route::get('/pdf/dashboard', [PdfController::class, 'dashboard'])->name('pdf.dashboard');

// API Routes
Route::get('/api/lgas/{stateId}', [\App\Http\Controllers\Api\LgaController::class, 'index']);
Route::get('/api/wards/{lgaId}', [\App\Http\Controllers\Api\WardController::class, 'index']);
Route::get('/api/polling-units/{wardId}', [\App\Http\Controllers\Api\PollingUnitController::class, 'index']);
