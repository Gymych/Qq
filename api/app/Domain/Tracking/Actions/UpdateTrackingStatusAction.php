<?php

namespace App\Domain\Tracking\Actions;

use App\Domain\Tracking\Models\Tracking;
use App\Domain\UPS\UpsService;
use App\Support\Actions\ActionFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UpdateTrackingStatusAction extends ActionFactory
{
    public function __construct(private readonly UpsService $service)
    {
    }

    protected function handle(string $trackingNumber): Model|Tracking
    {
        return DB::transaction(
            fn () => $this->service->updateTracking($trackingNumber)
        );
    }
}
