<?php

declare(strict_types=1);

namespace App\Domain\UPS\API;

use App\Domain\UPS\API\Concerns\BuildBaseRequest;
use App\Domain\UPS\API\Concerns\CanGetRequest;
use App\Domain\UPS\API\Concerns\CanPostRequest;
use App\Domain\UPS\API\Concerns\GetToken;
use App\Domain\UPS\API\Resources\Tracking;

final class UpsApiService
{
    use BuildBaseRequest, GetToken, CanGetRequest, CanPostRequest;

    public function __construct(
        private readonly string $baseUrl,
        private readonly string $clientId,
        private readonly string $clientSecret,
    ) {
    }

    /**
     * The Shipping Package API gives the application many ways to manage the shipment of packages to their destination.
     * @return Tracking
     */
    public function tracking(): Tracking
    {
        return new Tracking(service: $this);
    }
}
