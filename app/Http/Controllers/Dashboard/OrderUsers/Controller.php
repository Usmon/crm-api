<?php

namespace App\Http\Controllers\Dashboard\OrderUsers;

use App\Helpers\Json;

use App\Models\OrderUser;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\OrderUsers as OrderUsersRequest;

use App\Logic\Dashboard\CRUD\Services\OrderUsers as OrderUsersService;

use App\Logic\Dashboard\CRUD\Repositories\OrderUsers as OrderUsersRepository;

final class Controller extends Controllers
{
    /**
     * @var OrderUsersService
     */
    protected $service;

    /**
     * @var OrderUsersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param OrderUsersService $service
     *
     * @param OrderUsersRepository $repository
     */
    public function __construct(OrderUsersService $service, OrderUsersRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param OrderUsersRequest $request
     *
     * @return JsonResponse
     */
    public function index(OrderUsersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'order-users' => $this->service->getOrderUsers($this->repository->getOrderUsers($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param OrderUsersRequest $request
     *
     * @return JsonResponse
     */
    public function store(OrderUsersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The order-user was successfully created.',

            'order-user' => $this->repository->storeOrderUser($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param OrderUser $orderUser
     *
     * @return JsonResponse
     */
    public function show(OrderUser $orderUser): JsonResponse
    {
        return Json::sendJsonWith200([
            'order-user' => $this->service->showOrderUser($orderUser),
        ]);
    }

    /**
     * @param OrderUsersRequest $request
     *
     * @param OrderUser $orderUser
     *
     * @return JsonResponse
     */
    public function update(OrderUsersRequest $request, OrderUser $orderUser): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The order-user was successfully updated.',

            'order-user' => $this->repository->updateOrderUser($orderUser, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteOrderUser($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete order-user, parameters does not match.',
            ]);
        }

        $this->repository->deleteOrderUser($id);

        return Json::sendJsonWith200([
            'message' => 'The order-user was successfully deleted.',
        ]);
    }
}
