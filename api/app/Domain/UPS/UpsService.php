<?php

namespace App\Domain\UPS;

use App\Domain\Tracking\Repositories\TrackingRepository;
use App\Domain\UPS\API\UpsApiService;
use App\Domain\UPS\Dto\ShipmentActivityDto;
use App\Domain\UPS\Dto\ShipmentDto;
use App\Domain\UPS\Dto\ShipmentWeightDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use ReflectionException;

readonly class UpsService
{
    public function __construct(
        private UpsApiService $apiService,
        private TrackingRepository $repository
    )
    {
    }

    /**
     * Get tracking details
     * @param string $trackingNumber
     * @return ShipmentDto
     * @throws ConnectionException
     * @throws ReflectionException
     */
    public function getDetails(string $trackingNumber): ShipmentDto
    {
        $data = $this->getTrackingNumberData($trackingNumber);

        return ShipmentDto::noSnakeCase()->fromArray([
            'activity' => ShipmentActivityDto::noSnakeCase()->fromList($data['package'][0]['activity'])->toArray(),
            'weight' => ShipmentWeightDto::noSnakeCase()->fromArray($data['package'][0]['weight'])->toArray()
        ]);
    }

    /**
     * Update status of tracking
     * @param string $trackingNumber
     * @return Model
     */
    public function updateTracking(string $trackingNumber): Model
    {
        return DB::transaction(function() use ($trackingNumber){
            return $this->repository->updateStatus($trackingNumber, [...$this->getDetails($trackingNumber)->toArray()]);
        });
    }

    /**
     * Get Tracking Data
     * @param string $trackingNumber
     * @return array
     * @throws ConnectionException
     */
    private function getTrackingNumberData(string $trackingNumber): array
    {
        $trackingData = $this->apiService
            ->tracking()
            ->details($trackingNumber)
            ->json();

        if(
            !$trackingData ||
            !array_key_exists('trackResponse', $trackingData) ||
            !array_key_exists('shipment', $trackingData['trackResponse'])
        ){
            throw new ConnectionException('No tracking data found.');
        }

        return $trackingData['trackResponse']['shipment'][0];
    }
}
