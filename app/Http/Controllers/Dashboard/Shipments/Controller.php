<?php

namespace App\Http\Controllers\Dashboard\Shipments;

use App\Helpers\Json;

use App\Models\Shipment;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Shipments as ShipmentsRequest;

use App\Logic\Dashboard\CRUD\Services\Shipments as ShipmentsService;

use App\Logic\Dashboard\CRUD\Repositories\Shipments as ShipmentsRepository;
use Illuminate\Support\Facades\Gate;


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
        if(! Gate::check('Shipments')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'shipments' => $this->service->getShipments($this->repository->getShipments(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request),
            )),
        ]);
    }

    /**
     * @param ShipmentsRequest $request
     * @return JsonResponse
     */
    public function store(ShipmentsRequest $request): JsonResponse
    {
        if(! Gate::check('Shipments')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

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
        if(! Gate::check('Shipments')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

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
        if(! Gate::check('Shipments')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

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
        if(! Gate::check('Shipments')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        if (! $this->repository->deleteShipment($id)) {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete shipment, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The shipment was successfully deleted.',
        ]);
    }

    /**
     * @param int $shipmentId
     * @param ShipmentsRequest $request
     * @return JsonResponse
     */
    public function attachBoxes(int $shipmentId, ShipmentsRequest $request)
    {
        $this->repository->attachBoxes($this->service->attachBoxes($request), $shipmentId);

        return Json::sendJsonWith200([
            'message' => 'The boxes was successfully attached to shipment.',
        ]);
    }

    public function unAttachBoxes(ShipmentsRequest $request)
    {
        $this->repository->unAttachBoxes($this->service->unAttachBoxes($request));

        return Json::sendJsonWith200([
            'message' => 'The boxes was successfully unattached from shipment.',
        ]);
    }
}
