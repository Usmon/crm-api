<?php

namespace App\Http\Controllers\Dashboard\Statuses;

use App\Helpers\Json;

use App\Models\Status;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Services\Statuses as StatusesService;

use App\Logic\Dashboard\CRUD\Requests\Statuses as StatusesRequest;

use App\Logic\Dashboard\CRUD\Repositories\Statuses as StatusesRepository;

final class Controller extends Controllers
{
    /**
     * @var StatusesService
     */
    protected $service;

    /**
     * @var StatusesRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param StatusesService $service
     *
     * @param StatusesRepository $repository
     */
    public function __construct(StatusesService $service, StatusesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param StatusesRequest $request
     *
     * @return JsonResponse
     */
    public function index(StatusesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'sorts' => $this->service->getOnlySorts($request),

            'statuses' => $this->service->getStatuses($this->repository->getStatuses(
                $this->service->getOnlyFilters($request),

                $this->service->getOnlySorts($request)
            )),
        ]);
    }

    /**
     * @param StatusesRequest $request
     *
     * @return JsonResponse
     */
    public function store(StatusesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The status was successfully created.',

            'status' => $this->repository->storeStatus($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Status $status
     *
     * @return JsonResponse
     */
    public function show(Status $status): JsonResponse
    {
        return Json::sendJsonWith200([
            'status' => $this->service->showStatus($status),
        ]);
    }

    /**
     * @param StatusesRequest $request
     *
     * @param Status $status
     *
     * @return JsonResponse
     */
    public function update(StatusesRequest $request, Status $status): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The status was successfully updated.',

            'status' => $this->repository->updateStatus($status, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteStatus($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete status, parameters does not match.',
            ]);
        }

        $this->repository->deleteStatus($id);

        return Json::sendJsonWith200([
            'message' => 'The status was successfully deleted.',
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function statusDeliveries(): JsonResponse
    {
        return Json::sendJsonWith200([
            'statuses' => $this->service->getStatusDeliveries(),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function statusOrders(): JsonResponse
    {
        return Json::sendJsonWith200([
            'statuses' => $this->repository->getStatusesByModel($this->service::ORDER),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function statusPaymentOrders(): JsonResponse
    {
        $status = \App\Models\Status::where('model', 'OrderPayment')->get();
        return Json::sendJsonWith200([
            'payment_statuses' => $status,
            //'payment_statuses' => $this->service->getPaymentStatusOrders(),
        ]);
    }

    public function statusShipments(): JsonResponse
    {
        return Json::sendJsonWith200([
            'statuses' => $this->service->getStatusShipments(),
        ]);
    }
}
