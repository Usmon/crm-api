<?php

namespace App\Http\Controllers\Dashboard\FedexOrderItems;

use App\Helpers\Json;

use App\Models\FedexOrderItem;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\FedexOrderItem as FedexOrderItemsRequest;

use App\Logic\Dashboard\CRUD\Services\FedexOrderItems as FedexOrderItemsService;

use App\Logic\Dashboard\CRUD\Repositories\FedexOrderItems as FedexOrderItemsRepository;

final class Controller extends Controllers
{
    /**
     * @var FedexOrderItemsService
     */
    protected $service;

    /**
     * @var FedexOrderItemsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param FedexOrderItemsService $service
     *
     * @param FedexOrderItemsRepository $repository
     */
    public function __construct(FedexOrderItemsService $service, FedexOrderItemsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param FedexOrderItemsRequest $request
     *
     * @return JsonResponse
     */
    public function index(FedexOrderItemsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'fedex-order-items' => $this->service->getFedexOrderItems($this->repository->getFedexOrderItems($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param FedexOrderItemsRequest $request
     *
     * @return JsonResponse
     */
    public function store(FedexOrderItemsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The fedex-order-item was successfully created.',

            'fedex-order-item' => $this->repository->storeFedexOrderItem($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param FedexOrderItem $fedexOrderItem
     *
     * @return JsonResponse
     */
    public function show(FedexOrderItem $fedexOrderItem): JsonResponse
    {
        return Json::sendJsonWith200([
            'fedex-order-item' => $this->service->showFedexOrderItem($fedexOrderItem),
        ]);
    }

    /**
     * @param FedexOrderItemsRequest $request
     *
     * @param FedexOrderItem $fedexOrderItem
     *
     * @return JsonResponse
     */
    public function update(FedexOrderItemsRequest $request, FedexOrderItem $fedexOrderItem): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The fedex-order-item was successfully updated.',

            'fedex-order-item' => $this->repository->updateFedexOrderItem($fedexOrderItem, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteFedexOrderItem($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete fedex-order-item, parameters does not match.',
            ]);
        }

        $this->repository->deleteFedexOrderItem($id);

        return Json::sendJsonWith200([
            'message' => 'The fedex-order-item was successfully deleted.',
        ]);
    }
}
