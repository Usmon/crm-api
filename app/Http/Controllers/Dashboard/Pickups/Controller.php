<?php

namespace App\Http\Controllers\Dashboard\Pickups;

use App\Models\Pickup;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Pickups as PickupsRequest;

use App\Logic\Dashboard\CRUD\Services\Pickups as PickupsService;

use App\Logic\Dashboard\CRUD\Repositories\Pickups as PickupsRepository;

use Illuminate\Http\JsonResponse;

final class Controller extends Controllers
{
    /**
     * @var PickupsService
     */
    protected $service;

    /**
     * @var PickupsRepository
     */
    protected $repository;

    /**
     * @param PickupService $service
     *
     * @param PickupRepository $repository
     *
     * @return void
     */
    public function __construct(PickupsService $service, PickupsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param PickupsRequest $request
     *
     * @return JsonResponse
     */
    public function index(PickupsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'pickups' => $this->service->getPickups($this->repository->getPickups($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param PickupsRequest $request
     *
     * @return JsonResponse
     */
    public function store(PickupsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The pickup was succesfully created.',

            'pickup' => $this->repository->storePickup($this->service->createPickup($request)),
        ]);
    }

    /**
     * @param Pickup $pickup
     *
     * @return JsonResponse
     */
    public function show(Pickup $pickup): JsonResponse
    {
        return Json::sendJsonWith200([
            'pickup' => $this->service->showPickup($pickup),
        ]);
    }

    /**
     * @param PickupsRequest $request
     *
     * @param Pickup $pickup
     *
     * @return JsonResponse
     */
    public function update(PickupsRequest $request, Pickup $pickup): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The pickup was successfully updated.',

            'pickup' => $this->repository->updatePickup($pickup, $this->service->updatePickup($request)),
        ]);
    }

    /**
     * @param Pickup $pickup
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deletePickup($id);

        if(!$id)
        {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete pickup, please try again later.',
            ]);
        }

        $this->repository->deletePickup($id);

        return Json::sendJsonWith200([
            'message' => 'The pickup deleted successfully',
        ]);
    }



}