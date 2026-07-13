<?php

namespace App\Providers;

use App\Repositories\ElectionResultRepository;
use App\Repositories\LgaRepository;
use App\Repositories\PartyRepository;
use App\Repositories\PollingUnitRepository;
use App\Repositories\StateRepository;
use App\Repositories\WardRepository;
use App\Services\ElectionResultService;
use App\Services\StatisticsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(StateRepository::class);
        $this->app->singleton(LgaRepository::class);
        $this->app->singleton(WardRepository::class);
        $this->app->singleton(PollingUnitRepository::class);
        $this->app->singleton(PartyRepository::class);
        $this->app->singleton(ElectionResultRepository::class);
        $this->app->singleton(ElectionResultService::class);
        $this->app->singleton(StatisticsService::class);
    }

    public function boot(): void
    {
        //
    }
}
