<?php

namespace App\Domain\Tracking\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'tracking_number' => $this->tracking_number,
            'activity' => $this->activity,
            'weight' => $this->weight,
            'created_at' => $this->created_at->format('d M Y, H:i:s'),
            'updated_at' => $this->updated_at->format('d M Y, H:i:s')
        ];
    }
}
