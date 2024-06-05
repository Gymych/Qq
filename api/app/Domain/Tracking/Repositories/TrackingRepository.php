<?php

namespace App\Domain\Tracking\Repositories;
use App\Domain\Tracking\Models\Tracking;
use App\Support\Repositories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TrackingRepository extends Repositories
{

    protected function getModel(): Model
    {
        return new Tracking();
    }

    /**
     * Get All with pagination
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(int $perPage = 10): LengthAwarePaginator
    {
        return $this->query()->paginate($perPage);
    }

    /**
     * Update Tracking Status
     * @param string $trackingNumber
     * @param array $data
     * @return Model
     */
    public function updateStatus(string $trackingNumber, array $data): Model
    {
        $model = $this->findByTrackingNumber($trackingNumber);
        $model->fill($data);
        $model->save();

        return $model->refresh();
    }

    /**
     * Find Tracking by tracking number
     * @param string $trackingNumber
     * @return Model
     */
    public function findByTrackingNumber(string $trackingNumber): Model
    {
        return $this->query()->where('tracking_number', '=', $trackingNumber)->first();
    }
}
