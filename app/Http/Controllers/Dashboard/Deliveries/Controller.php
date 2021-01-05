<?php

namespace App\Http\Controllers\Dashboard\Deliveries;

use App\Helpers\Json;

use App\Models\Delivery;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Deliveries as DeliveriesRequest;

use App\Logic\Dashboard\CRUD\Services\Deliveries as DeliveriesService;

use App\Logic\Dashboard\CRUD\Repositories\Deliveries as DeliveriesRepository;

final class Controller extends Controllers
{
    /**
     * @var DeliveriesService
     */
    protected $service;

    /**
     * @var DeliveriesRepository
     */
    protected $repository;

    /**
     * @param DeliveriesService $service
     *
     * @param DeliveriesRepository $repository
     *
     * @return void
     */
    public function __construct(DeliveriesService $service, DeliveriesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param DeliveriesRequest $request
     *
     * @return JsonResponse
     */
    public function index(DeliveriesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'deliveries' => $this->service->getDeliveries($this->repository->getDeliveries(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request)
            ))
        ]);

    }

    /**
     * @param DeliveriesRequest $request
     *
     * @return JsonResponse
     */
    public function store(DeliveriesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The delivery was successfully created.',

            'delivery' => $this->repository->storeDelivery($this->service->createDelivery($request)),
        ]);
    }

    /**
     * @param Delivery $delivery
     *
     * @return JsonResponse
     */
    public function show(Delivery $delivery): JsonResponse
    {
        return Json::sendJsonWith200([
            'delivery' => $this->service->showDelivery($delivery),

        ]);
    }

    /**
     * @param DeliveriesRequest $request
     *
     * @param Delivery $delivery
     *
     * @return JsonResponse
     */
    public function update(DeliveriesRequest $request, Delivery $delivery): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The delivery was successfully updated.',

            'delivery' => $this->repository->updateDelivery($delivery, $this->service->updateDelivery($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteDelivery($id);

        if(!$id)
        {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete delivery, please try again later.',
            ]);
        }

        $this->repository->deleteDelivery($id);

        return Json::sendJsonWith200([
            'message' => 'The delivery deleted successfully.',
        ]);
    }
}
