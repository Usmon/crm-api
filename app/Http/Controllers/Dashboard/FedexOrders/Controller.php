<?php

namespace App\Http\Controllers\Dashboard\FedexOrders;

use App\Helpers\Json;

use App\Models\FedexOrder;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\FedexOrders as FedexOrdersRequest;

use App\Logic\Dashboard\CRUD\Services\FedexOrders as FedexOrdersService;

use App\Logic\Dashboard\CRUD\Repositories\FedexOrders as FedexOrdersRepository;

use Illuminate\Http\JsonResponse;

final class Controller extends Controllers
{
    /**
     * @var FedexOrdersService
     */
    protected $service;

    /**
     * @var FedexOrdersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param FedexOrdersService $service
     *
     * @param FedexOrdersRepository $repository
     */
    public function __construct(FedexOrdersService $service, FedexOrdersRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param FedexOrdersRequest $request
     * @return JsonResponse
     */
    public function index(FedexOrdersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'fedex-orders' => $this->service->getFedexOrders($this->repository->getFedexOrders($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param FedexOrdersRequest $request
     * @return JsonResponse
     */
    public function store(FedexOrdersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The fedex-order was successfully created.',

            'fedex-order' => $this->repository->storeFedexOrder($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param FedexOrder $fedexOrder
     * @return JsonResponse
     */
    public function show(FedexOrder $fedexOrder): JsonResponse
    {
        return Json::sendJsonWith200([
            'fedex-order' => $this->service->showFedexOrder($fedexOrder),
        ]);
    }

    /**
     * @param FedexOrdersRequest $request
     * @param FedexOrder $fedexOrder
     * @return JsonResponse
     */
    public function update(FedexOrdersRequest $request, FedexOrder $fedexOrder): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The fedex-order was successfully updated.',

            'fedex-order' => $this->repository->updateFedexOrder($fedexOrder, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param FedexOrder $fedexOrder
     * @return JsonResponse
     */
    public function destroy(FedexOrder $fedexOrder): JsonResponse
    {
        if (! $this->repository->deleteFedexOrder($fedexOrder)) {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete fedex-order, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The fedex-order was successfully deleted.',
        ]);
    }
}
