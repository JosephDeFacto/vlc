<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\ApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ApiService::class, function ($app) {
            return new ApiService(config('api.api_url'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
