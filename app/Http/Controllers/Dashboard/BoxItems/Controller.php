<?php

namespace App\Http\Controllers\Dashboard\BoxItems;

use App\Models\BoxItem;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\BoxItems as BoxItemsRequest;

use App\Logic\Dashboard\CRUD\Services\BoxItems as BoxItemsService;

use App\Logic\Dashboard\CRUD\Repositories\BoxItems as BoxItemsRepository;

use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

final class Controller extends Controllers
{
    /**
     * @var BoxItemsService;
     */
    protected $service;

    /**
     * @var BoxItemsRepository
     */
    protected $repository;

    /**
     * @param BoxItemsService $service
     *
     * @param BoxItemsRepository $repository
     *
     * @return void
     */
    public function __construct(BoxItemsService $service, BoxItemsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param BoxItemsRequest $request
     *
     * @return JsonResponse
     */
    public function index(BoxItemsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'box_items' => $this->service->getBoxItems($this->repository->getBoxItems($this->service->getOnlyFilters($request))),
        ]);

    }

    /**
     * @param BoxItemsRequest $request
     *
     * @return JsonResponse
     */
    public function store(BoxItemsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The box item was successfully created.',

            'box_item' => $this->repository->storeBoxItem($this->service->createBoxItem($request)),
        ]);
    }

    /**
     * @param BoxItem $boxItem
     *
     * @return JsonResponse
     */
    public function show(BoxItem $boxItem): JsonResponse
    {
        return Json::sendJsonWith200([
            'box_item' => $this->service->showBoxItem($boxItem),

        ]);
    }

    /**
     * @param BoxItemsRequest $request
     *
     * @param BoxItem $boxItem
     *
     * @return JsonResponse
     */
    public function update(BoxItemsRequest $request, BoxItem $boxItem): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The box item was successfully updated.',

            'box_item' => $this->repository->updateBoxItem($boxItem, $this->service->updateBoxItem($request)),
        ]);
    }

    /**
     * @param BoxItem $boxItem
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteBoxItem($id);

        if(!$id)
        {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete box item, please try again later.',
            ]);
        }

        $this->repository->deleteBoxItem($id);

        return Json::sendJsonWith200([
            'message' => 'The box item deleted successfully.',
        ]);
    }
}
