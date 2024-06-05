<?php

namespace App\Domain\UPS;

use App\Domain\UPS\API\UpsApiService;
use App\Support\AbstractServiceProvider;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class UpsServiceProvider extends AbstractServiceProvider
{

    public function setDomain(): string
    {
        return 'UPS';
    }

    public function boot(): void
    {
        // Important to call the parent boot method
        parent::boot();

        // Bind the WeatherService to the container
        $this->app->singleton(abstract: UpsApiService::class, concrete: fn () => new UpsApiService(
            baseUrl: config('services.ups.api.base_url'),
            clientId: config('services.ups.client_id'),
            clientSecret: config('services.ups.client_secret'),
        ));
    }
}
