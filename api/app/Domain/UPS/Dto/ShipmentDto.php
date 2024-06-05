<?php

namespace App\Domain\UPS\Dto;

use App\Support\DataObjects;

class ShipmentDto extends DataObjects
{
    public function __construct(
        public readonly array|ShipmentActivityDto $activity,
        public readonly array|ShipmentWeightDto $weight
    )
    {
    }
}
