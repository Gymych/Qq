<?php

namespace App\Domain\Tracking\Controllers;

use App\Domain\Tracking\Actions\CreateTrackingAction;
use App\Domain\Tracking\Actions\GetAllTrackingAction;
use App\Domain\Tracking\Actions\GetTrackingNumberAction;
use App\Domain\Tracking\Actions\UpdateTrackingStatusAction;
use App\Domain\Tracking\Requests\CreateTrackingRequest;
use App\Domain\Tracking\Requests\FindTrackingRequest;
use App\Support\ApiControllers;

use Exception;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use Symfony\Component\HttpFoundation\Response;

class TrackingController extends ApiControllers
{
    /**
     * Get All Tracking Numbers
     * @return Response
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
    public function all(): Response
    {
        return rescue(
            fn () => $this->success(GetAllTrackingAction::run()),
            $this->throwValidationException()
        );
    }

    /**
     * Create new tracking number
     * @param CreateTrackingRequest $request
     * @return Response
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
    public function create(CreateTrackingRequest $request):Response
    {
        return rescue(
            fn () => $this->success([
                "tracked_package" => CreateTrackingAction::run(
                    userId: $request->user()->id,
                    trackingNumber: $request->validated('tracking_number')
                )
            ]),
            $this->throwValidationException()
        );
    }

    /**
     * Find Tracking Number
     * @param FindTrackingRequest $request
     * @return Response
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @throws Exception
     */
    public function details(FindTrackingRequest $request): Response
    {
        return rescue(
            fn () => $this->success(GetTrackingNumberAction::run($request->validated('tracking_number'))),
            $this->throwValidationException()
        );
    }

    /**
     * Update Tracking Package status
     * @param FindTrackingRequest $request
     * @return Response|null
     * @throws Exception
     */
    public function updateStatus(FindTrackingRequest $request): ?Response
    {
        return rescue(
          fn () => $this->noContentClosure(UpdateTrackingStatusAction::run(
              $request->validated('tracking_number')
          ))
        );
    }
}
