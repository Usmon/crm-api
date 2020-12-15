<?php

namespace App\Http\Controllers\Dashboard\DeliveryUsers;

use App\Helpers\Json;

use App\Models\DeliveryUser;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\DeliveryUsers as DeliveryUsersRequest;

use App\Logic\Dashboard\CRUD\Services\DeliveryUsers as DeliveryUsersService;

use App\Logic\Dashboard\CRUD\Repositories\DeliveryUsers as DeliveryUsersRepository;

final class Controller extends Controllers
{
    /**
     * @var DeliveryUsersService
     */
    protected $service;

    /**
     * @var DeliveryUsersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param DeliveryUsersService $service
     *
     * @param DeliveryUsersRepository $repository
     */
    public function __construct(DeliveryUsersService $service, DeliveryUsersRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param DeliveryUsersRequest $request
     *
     * @return JsonResponse
     */
    public function index(DeliveryUsersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'delivery-users' => $this->service->getDeliveryUsers($this->repository->getDeliveryUsers($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param DeliveryUsersRequest $request
     *
     * @return JsonResponse
     */
    public function store(DeliveryUsersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The delivery-user was successfully created.',

            'delivery-user' => $this->repository->storeDeliveryUser($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param DeliveryUser $deliveryUser
     *
     * @return JsonResponse
     */
    public function show(DeliveryUser $deliveryUser): JsonResponse
    {
        return Json::sendJsonWith200([
            'delivery-user' => $this->service->showDeliveryUser($deliveryUser),
        ]);
    }

    /**
     * @param DeliveryUsersRequest $request
     *
     * @param DeliveryUser $deliveryUser
     *
     * @return JsonResponse
     */
    public function update(DeliveryUsersRequest $request, DeliveryUser $deliveryUser): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The delivery-user was successfully updated.',

            'delivery-user' => $this->repository->updateDeliveryUser($deliveryUser, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteDeliveryUser($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete delivery-user, parameters does not match.',
            ]);
        }

        $this->repository->deleteDeliveryUser($id);

        return Json::sendJsonWith200([
            'message' => 'The delivery-user was successfully deleted.',
        ]);
    }
}
