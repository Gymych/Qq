<?php

namespace Database\Factories;

use App\Domain\Auth\Models\User;
use App\Domain\Tracking\Models\Tracking;
use App\Domain\UPS\UpsService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tracking>
 */
class TrackingFactory extends Factory
{
    protected $model = Tracking::class;

    public function definition(): array
    {
        return [
            'tracking_number' => $this->generateTrackingNumber(),
            'user_id' => User::factory()
        ];
    }

    /**
     * Random generate tracking number.
     * @return string
     */
    private function generateTrackingNumber(): string
    {
        return $this->faker->bothify('##################');
    }

    /**
     * Get the service.
     * @return UpsService
     */
    private function getService(): UpsService
    {
        return app(UpsService::class);
    }

    /**
     * Get With Details
     * @return $this
     */
    public function details(): static
    {
        return $this->state(function(array $attributes){
            return $this->getService()->getDetails($attributes['tracking_number'])->toArray();
        });
    }
}
