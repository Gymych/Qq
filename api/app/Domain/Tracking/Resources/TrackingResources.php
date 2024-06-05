<?php

namespace App\Domain\Tracking\Resources;

use App\Domain\Tracking\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TrackingResources extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'tracking_numbers' => $this->collection->map(
                fn (Tracking $tracking) => TrackingResource::make($tracking)->resolve()
            )->toArray(),
            'links' => [
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
        ];
    }
}
