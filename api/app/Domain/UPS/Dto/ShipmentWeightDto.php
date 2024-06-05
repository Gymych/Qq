<?php

namespace App\Domain\UPS\Dto;

use App\Support\DataObjects;

class ShipmentWeightDto extends DataObjects
{
    public function __construct(
        public readonly string $unitOfMeasurement,
        public readonly string $weight,
    )
    {
    }
}
