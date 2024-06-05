<?php

namespace App\Domain\UPS\API\Resources;

use App\Domain\UPS\API\Resource;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;

final class Tracking extends Resource
{
    protected ?string $prefix = 'track';

    /**
     * Get Tracking Details
     * @param string $trackingNumber
     * @param string $transId
     * @param string $transactionSrc
     * @return Response
     * @throws ConnectionException
     */
    public function details(
        string $trackingNumber,
        string $transId = "test",
        string $transactionSrc = "testing"
    ): Response
    {
        return $this->service->get(
            url: $this->endpoint("details/{$trackingNumber}"),
            data: [
                'local' => 'en_US',
                'returnSignature' => false,
                'returnMilestones' => false,
                'returnPOD' => false
            ],
            headers:['transId' => $transId, 'transactionSrc' => $transactionSrc]
        );
    }
}
