<?php

namespace App\Providers;

use App\Services\ActorDataCache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register actor data cache as singleton to prevent duplicate AI calls
        $this->app->singleton(ActorDataCache::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
