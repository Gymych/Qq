<?php

declare(strict_types=1);

namespace App\Domain\UPS\API\Guzzle;

use Closure;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Psr\Http\Message\RequestInterface;

class ProxyValidationErrors
{
    public function __invoke($handler): Closure
    {
        return function (RequestInterface $request, array $options) use (&$handler) {

            try {
                return $handler($request, $options)->then(function (Response $response) {
                    $content = $response->getBody()->getContents();

                    $jsonData = json_decode($content, true);

                    if (is_array($jsonData) && $this->isValidationErrorType($jsonData)) {
                        throw new ValidationException(
                            tap(
                                Validator::make([], []),
                                function ($validator) use ($jsonData) {
                                    return collect($this->getErrorFields($jsonData))
                                        ->each(function ($error) use ($validator) {
                                            $validator->errors()->add($error['code'], $error['message']);
                                        });
                                }
                            )
                        );
                    }

                    return $response;
                });
            } catch (ValidationException $e) {
                Log::error('Validation error occurred in ProxyValidation: '.$e->getMessage());
                throw $e;
            }
        };
    }

    /**
     * Check if the response indicates a validation error
     */
    private function isValidationErrorType(array $data): bool
    {
        return isset($data['response']['errors']);
    }

    /**
     * Get fields errors
     */
    private function getErrorFields(array $errorData): array
    {
        return $errorData['response']['errors'];
    }
}
