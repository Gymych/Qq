<?php

namespace App\Domain\Tracking\Actions;

use App\Domain\Tracking\Repositories\TrackingRepository;
use App\Domain\Tracking\Resources\TrackingResources;
use App\Support\Actions\ActionFactory;
use Illuminate\Support\Facades\DB;

class GetAllTrackingAction extends ActionFactory
{
    public function __construct(
        private readonly TrackingRepository $repository,
    )
    {
    }

    /**
     * Get All Tracking numbers
     * @return array|null
     */
    protected function handle(): ?array
    {
        return DB::transaction(
            fn () => TrackingResources::make(
                $this->repository->getAll()
            )->resolve()
        );
    }
}
