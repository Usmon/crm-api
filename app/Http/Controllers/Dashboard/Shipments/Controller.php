<?php

namespace App\Http\Controllers\Dashboard\Shipments;

use App\Models\Shipment;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Shipments as ShipmentsRequest;

use App\Logic\Dashboard\CRUD\Services\Shipments as ShipmentsService;

use App\Logic\Dashboard\CRUD\Repositories\Shipments as ShipmentsRepository;

use Illuminate\Http\JsonResponse;

final class Controller extends Controllers
{
    /**
     * @var ShipmentsService
     */
    protected $service;

    /**
     * @var ShipmentsRepository
     */
    protected $repository;

    /**
     * @param ShipmentsService $service
     *
     * @param ShipmentsRepository $repository
     *
     * @return void
     */
    public function __construct(ShipmentsService $service, ShipmentsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param ShipmentsRequest $request
     *
     * @return JsonResponse
     */
    public function index(ShipmentsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'shipments' => $this->service->getShipments($this->repository->getShipments($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param ShipmentsRequest $request
     *
     * @return JsonResponse
     */
    public function store(ShipmentsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The shipment was successfully created.',

            'shipment' => $this->repository->storeShipment($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Shipment $shipment
     *
     * @return JsonResponse
     */
    public function show(Shipment $shipment): JsonResponse
    {
        return Json::sendJsonWith200([
            'shipment' => $this->service->showShipment($shipment),
        ]);
    }

    /**
     * @param ShipmentsRequest $request
     *
     * @param Shipment $shipment
     *
     * @return JsonResponse
     */
    public function update(ShipmentsRequest $request, Shipment $shipment): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The shipment was successfully updated.',

            'shipment' => $this->repository->updateShipment($shipment, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        if (! $this->repository->deleteShipment($id)) {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete shipment, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The shipment was successfully deleted.',
        ]);
    }
}