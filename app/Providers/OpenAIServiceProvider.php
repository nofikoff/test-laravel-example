<?php

namespace App\Providers;

use App\Contracts\AIServiceInterface;
use App\Services\AI\OpenAIService;
use Illuminate\Support\ServiceProvider;

class OpenAIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind AI Service Interface
        $this->app->singleton(AIServiceInterface::class, function ($app) {
            return new OpenAIService(
                apiKey: config('openai.api_key'),
                model: config('openai.model')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

