<?php

namespace App\Http\Controllers\Dashboard\WarehouseItems;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\WarehouseItems as WarehouseItemsRequest;

use App\Logic\Dashboard\CRUD\Services\WarehouseItems as WarehouseItemsService;

use App\Logic\Dashboard\CRUD\Repositories\WarehouseItems as WarehouseItemsRepository;

use App\Models\WarehouseItem;

use Illuminate\Http\JsonResponse;

final class Controller extends Controllers
{
    /**
     * @var WarehouseItemsService
     */
    protected $service;

    /**
     * @var WarehouseItemsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param WarehouseItemsService $service
     *
     * @param WarehouseItemsRepository $repository
     */
    public function __construct(WarehouseItemsService $service, WarehouseItemsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param WarehouseItemsRequest $request
     *
     * @return JsonResponse
     */
    public function index(WarehouseItemsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'warehouse-items' => $this->service->getWarehouseItems($this->repository->getWarehouseItems($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param WarehouseItemsRequest $request
     *
     * @return JsonResponse
     */
    public function store(WarehouseItemsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The warehouse-item was successfully created.',

            'warehouse-item' => $this->repository->storeWarehouseItem($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param WarehouseItem $warehouseItem
     *
     * @return JsonResponse
     */
    public function show(WarehouseItem $warehouseItem): JsonResponse
    {
        return Json::sendJsonWith200([
            'warehouse-item' => $this->service->showWarehouseItem($warehouseItem)
        ]);
    }

    /**
     * @param WarehouseItemsRequest $request
     *
     * @param WarehouseItem $warehouseItem
     *
     * @return JsonResponse
     */
    public function update(WarehouseItemsRequest $request, WarehouseItem $warehouseItem): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The warehouse-item was successfully updated.',

            'shipment' => $this->repository->updateWarehouseItem($warehouseItem, $this->service->updateCredentials($request))
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteWarehouseItem($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete order, parameters does not match.',
            ]);
        }

        $this->repository->deleteWarehouseItem($id);

        return Json::sendJsonWith200([
            'message' => 'The order was successfully deleted.',
        ]);
    }
}
