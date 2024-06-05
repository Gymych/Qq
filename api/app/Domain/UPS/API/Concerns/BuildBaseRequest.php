<?php

declare(strict_types=1);

namespace App\Domain\UPS\API\Concerns;

use App\Domain\UPS\API\Guzzle\ProxyValidationErrors;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Psr\SimpleCache\InvalidArgumentException;

trait BuildBaseRequest
{
    /**
     * @return PendingRequest
     * @throws ConnectionException
     */
    public function buildRequestWithToken(): PendingRequest
    {
        return $this->withBaseUrl()
            ->withToken(token: $this->getAccessToken())
            ->timeout(
                seconds: 15,
            )->withMiddleware(
                new ProxyValidationErrors()
            )->withMiddleware(
                $this->getCacheMiddleware()
            );
    }

    /**
     * Initialize base url
     */
    public function withBaseUrl(): PendingRequest
    {
        return Http::baseUrl(
            url: $this->baseUrl,
        );
    }

    /**
     * Get cache middleware
     */
    protected function getCacheMiddleware(): CacheMiddleware
    {
        return new CacheMiddleware(
            new PrivateCacheStrategy(new LaravelCacheStorage(cache()->store()))
        );
    }
}
