<?php

namespace App\Domain\Tracking\Actions;

use App\Domain\Tracking\Repositories\TrackingRepository;
use App\Domain\Tracking\Resources\TrackingResource;
use App\Support\Actions\ActionFactory;
use Illuminate\Support\Facades\DB;

class GetTrackingNumberAction extends ActionFactory
{
    public function __construct(
        private readonly TrackingRepository $repository
    )
    {
    }

    protected function handle(string $trackingNumber): array
    {
        return DB::transaction(
            fn () => TrackingResource::make(
                $this->repository->findByTrackingNumber($trackingNumber)
            )->resolve()
        );
    }
}
