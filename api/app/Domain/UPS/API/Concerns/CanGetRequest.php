<?php

declare(strict_types=1);

namespace App\Domain\UPS\API\Concerns;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;

trait CanGetRequest
{
    /**
     * Get Request from API
     * @throws ConnectionException
     */
    public function get(string $url, ?array $data = null, array $headers = []): Response
    {
        return $this->buildRequestWithToken()
            ->withHeaders($headers)
            ->get(
                url: $url,
                query: $data
            );
    }
}
