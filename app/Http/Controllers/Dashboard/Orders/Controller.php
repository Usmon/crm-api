<?php

namespace App\Http\Controllers\Dashboard\Orders;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Orders as OrdersRequest;

use App\Logic\Dashboard\CRUD\Services\Orders as OrdersService;

use App\Logic\Dashboard\CRUD\Repositories\Orders as OrdersRepository;

use App\Models\Order;

use Illuminate\Http\JsonResponse;

final class Controller extends Controllers
{
    /**
     * @var OrdersService
     */
    protected $service;

    /**
     * @var OrdersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param OrdersService $service
     *
     * @param OrdersRepository $repository
     */
    public function __construct(OrdersService $service, OrdersRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param OrdersRequest $request
     *
     * @return JsonResponse
     */
    public function index(OrdersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'orders' => $this->service->getOrders($this->repository->getOrders($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param OrdersRequest $request
     *
     * @return JsonResponse
     */
    public function store(OrdersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The order was successfully created.',

            'order' => $this->repository->storeOrder($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Order $order
     *
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        return Json::sendJsonWith200([
            'order' => $this->service->showOrder($order),
        ]);
    }

    /**
     * @param OrdersRequest $request
     *
     * @param Order $order
     *
     * @return JsonResponse
     */
    public function update(OrdersRequest $request, Order $order): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The order was successfully updated.',

            'fedex' => $this->repository->updateOrder($order, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteOrder($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete order, parameters does not match.',
            ]);
        }

        $this->repository->deleteOrder($id);

        return Json::sendJsonWith200([
            'message' => 'The order was successfully deleted.',
        ]);
    }
}