<?php

namespace App\Domain\Tracking\Actions;

use App\Domain\Tracking\Repositories\TrackingRepository;
use App\Domain\Tracking\Resources\TrackingResource;
use App\Domain\UPS\UpsService;
use App\Support\Actions\ActionFactory;
use Illuminate\Support\Facades\DB;

class CreateTrackingAction extends ActionFactory
{
    public function __construct(
        private readonly TrackingRepository $repository,
        private readonly UpsService $service
    )
    {
    }

    protected function handle(string $userId, string $trackingNumber): array
    {
        return DB::transaction(function() use ($userId, $trackingNumber){
            $data = $this->service->getDetails($trackingNumber);
            return TrackingResource::make($this->repository->create([
                'user_id' => $userId,
                'tracking_number' => $trackingNumber,
                ...$data->toArray()
            ]))->resolve();
        });
    }
}
