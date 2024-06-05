<?php

declare(strict_types=1);

namespace App\Domain\UPS\API;

abstract class Resource
{
    protected ?string $prefix = null;

    public function __construct(
        public readonly UpsApiService $service,
        public string $version = 'v1'
    )
    {
    }

    /**
     * Make endpoint with prefix
     */
    protected function endpoint(?string $path = null): string
    {
        return $path ? "api/$this->prefix/$this->version/$path" : "api/$this->prefix/$this->version";
    }
}
