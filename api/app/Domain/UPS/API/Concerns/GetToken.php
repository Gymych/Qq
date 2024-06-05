<?php

namespace App\Domain\UPS\API\Concerns;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

trait GetToken
{
    /**
     * Get Access Token
     * @return string|ConnectionException
     * @throws ConnectionException
     */
    protected function getAccessToken(): string|ConnectionException
    {
        return Cache::has('ups_api_token') ? Cache::get('ups_api_token') : $this->getNewAccessToken();
    }

    /**
     * Get New Access Token
     * @return string|ConnectionException
     * @throws ConnectionException
     */
    protected function getNewAccessToken(): string|ConnectionException
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $this->authHeader(),
        ])->asForm()->post(
            url: $this->baseUrl.'/security/v1/oauth/token',
            data: [
                'grant_type' => 'client_credentials',
            ]
        );

        if($response->successful()){
            $tokenData = $response->json();
            $expiresIn = $tokenData['expires_in'] ?? 0;

            Cache::put('ups_api_token', $tokenData['access_token'], 3600);
            return $tokenData['access_token'];
        }

        throw new ConnectionException('Could not get access token');
    }

    /**
     * Get Auth Header
     * @return string
     */
    private function authHeader(): string
    {
        return "Basic " . base64_encode($this->clientId . ':' . $this->clientSecret);
    }
}
