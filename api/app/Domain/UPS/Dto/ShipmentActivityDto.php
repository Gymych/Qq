<?php

namespace App\Domain\UPS\Dto;

use App\Support\DataObjects;

class ShipmentActivityDto extends DataObjects
{
    public function __construct(
        public readonly array $location,
        public readonly array $status,
        public readonly string $date,
        public readonly string $time,
        public readonly string $gmtDate,
        public readonly string $gmtOffset,
        public readonly string $gmtTime
    )
    {
    }
}
