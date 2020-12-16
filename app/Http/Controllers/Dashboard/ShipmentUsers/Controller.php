<?php

namespace App\Http\Controllers\Dashboard\ShipmentUsers;

use App\Helpers\Json;

use App\Models\ShipmentUser;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\ShipmentUsers as ShipmentUsersRequest;

use App\Logic\Dashboard\CRUD\Services\ShipmentUsers as ShipmentUsersService;

use App\Logic\Dashboard\CRUD\Repositories\ShipmentUsers as ShipmentUsersRepository;

final class Controller extends Controllers
{
    /**
     * @var ShipmentUsersService
     */
    protected $service;

    /**
     * @var ShipmentUsersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param ShipmentUsersService $service
     *
     * @param ShipmentUsersRepository $repository
     */
    public function __construct(ShipmentUsersService $service, ShipmentUsersRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param ShipmentUsersRequest $request
     *
     * @return JsonResponse
     */
    public function index(ShipmentUsersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'shipment-users' => $this->service->getShipmentUsers($this->repository->getShipmentUsers($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param ShipmentUsersRequest $request
     *
     * @return JsonResponse
     */
    public function store(ShipmentUsersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The shipment-user was successfully created.',

            'shipment-user' => $this->repository->storeShipmentUser($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param ShipmentUser $shipmentUser
     *
     * @return JsonResponse
     */
    public function show(ShipmentUser $shipmentUser): JsonResponse
    {
        return Json::sendJsonWith200([
            'shipment-user' => $this->service->showShipmentUser($shipmentUser),
        ]);
    }

    /**
     * @param ShipmentUsersRequest $request
     *
     * @param ShipmentUser $shipmentUser
     *
     * @return JsonResponse
     */
    public function update(ShipmentUsersRequest $request, ShipmentUser $shipmentUser): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The shipment-user was successfully updated.',

            'shipment-user' => $this->repository->updateShipmentUser($shipmentUser, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteShipmentUser($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete shipment-user, parameters does not match.',
            ]);
        }

        $this->repository->deleteShipmentUser($id);

        return Json::sendJsonWith200([
            'message' => 'The shipment-user was successfully deleted.',
        ]);
    }
}
