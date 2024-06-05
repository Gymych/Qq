<?php

namespace App\Domain\Tracking\Models;

use App\Support\ReadModel;

use Database\Factories\TrackingFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class Tracking extends ReadModel
{
    protected $fillable = [
        'user_id',
        'tracking_number',
        'activity',
        'weight'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tracking_number' => 'string',
            'activity' => 'array',
            'weight' => 'array'
        ];
    }

    /**
     * Get Table name of model
     * @return string
     */
    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    protected static function newFactory(): Factory|TrackingFactory
    {
        return TrackingFactory::new();
    }
}
