<?php

namespace App\Domain\Tracking;

use App\Support\AbstractServiceProvider;

class TrackingServiceProvider extends AbstractServiceProvider
{
    public function setDomain(): string
    {
        return 'Tracking';
    }
}
