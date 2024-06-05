<?php

declare(strict_types=1);

namespace App\Domain\UPS\API\Concerns;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Psr\SimpleCache\InvalidArgumentException;

trait CanPostRequest
{
    /**
     * Send post request to the api
     * @param string $url
     * @param array $data
     * @return Response
     * @throws ConnectionException
     * @throws InvalidArgumentException
     */
    public function post(string $url, array $data = []): Response
    {
        return $this->buildRequestWithToken()->post(
            url: $url,
            data: $data
        );
    }
}
