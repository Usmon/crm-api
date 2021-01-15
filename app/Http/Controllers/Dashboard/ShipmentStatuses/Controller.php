<?php

namespace App\Http\Controllers\Dashboard\ShipmentStatuses;

use App\Helpers\Json;

use App\Models\ShipmentStatus;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\ShipmentStatuses;

use App\Logic\Dashboard\CRUD\Services\ShipmentStatuses as ShipmentStatusesService;

use App\Logic\Dashboard\CRUD\Requests\ShipmentStatuses as ShipmentStatusesRequest;

use App\Logic\Dashboard\CRUD\Repositories\ShipmentStatuses as ShipmentStatusesRepository;

final class Controller extends Controllers
{
    /**
     * @var ShipmentStatusesService
     */
    protected $service;

    /**
     * @var ShipmentStatusesRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param ShipmentStatusesService $service
     *
     * @param ShipmentStatusesRepository $repository
     */
    public function __construct(ShipmentStatusesService $service, ShipmentStatusesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param ShipmentStatusesRequest $request
     *
     * @return JsonResponse
     */
    public function index(ShipmentStatusesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'shipment_statuses' => $this->service->getShipmentStatuses($this->repository->getShipmentStatuses(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request))),
        ]);
    }

    /**
     * @param ShipmentStatusesRequest $request
     *
     * @return JsonResponse
     */
    public function store(ShipmentStatusesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The shipment-status was successfully created.',

            'shipment_status' => $this->repository->storeShipmentStatus($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param ShipmentStatus $status
     *
     * @return JsonResponse
     */
    public function show(ShipmentStatus $status): JsonResponse
    {
        return Json::sendJsonWith200([
            'shipment_status' => $this->service->showShipmentStatus($status),
        ]);
    }

    /**
     * @param ShipmentStatusesRequest $request
     *
     * @param ShipmentStatus $status
     *
     * @return JsonResponse
     */
    public function update(ShipmentStatusesRequest $request, ShipmentStatus $status): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The shipment-status was successfully updated.',

            'shipment_status' => $this->repository->updateShipmentStatus($status, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteShipmentStatus($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete shipment-status, parameters does not match.',
            ]);
        }

        $this->repository->deleteShipmentStatus($id);

        return Json::sendJsonWith200([
            'message' => 'The shipment-status was successfully deleted.',
        ]);
    }
}
