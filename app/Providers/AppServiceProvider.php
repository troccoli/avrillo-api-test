<?php

namespace App\Providers;

use App\Contracts\KayneWestServiceInterface;
use App\Services\KayneWestService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(KayneWestServiceInterface::class, KayneWestService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
