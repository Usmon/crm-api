<?php

namespace App\Http\Controllers\Dashboard\ShipmentComments;

use App\Models\ShipmentComment;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\ShipmentComments as ShipmentCommentsRequest;

use App\Logic\Dashboard\CRUD\Services\ShipmentComments as ShipmentCommentsService;

use App\Logic\Dashboard\CRUD\Repositories\ShipmentComments as ShipmentCommentsRepository;

final class Controller extends Controllers
{
    /**
     * @var ShipmentCommentsService
     */
    protected $service;

    /**
     * @var ShipmentCommentsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param ShipmentCommentsService $service
     *
     * @param ShipmentCommentsRepository $repository
     */
    public function __construct(ShipmentCommentsService $service, ShipmentCommentsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param ShipmentCommentsRequest $request
     *
     * @return JsonResponse
     */
    public function index(ShipmentCommentsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'shipment-comments' => $this->service->getShipmentComments($this->repository->getShipmentComments($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param ShipmentCommentsRequest $request
     *
     * @return JsonResponse
     */
    public function store(ShipmentCommentsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The shipment-comment was successfully created.',

            'shipment-comment' => $this->repository->storeShipmentComment($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param ShipmentComment $shipmentComment
     *
     * @return JsonResponse
     */
    public function show(ShipmentComment $shipmentComment): JsonResponse
    {
        return Json::sendJsonWith200([
            'shipment-comment' => $this->service->showShipmentComment($shipmentComment),
        ]);
    }

    /**
     * @param ShipmentCommentsRequest $request
     *
     * @param ShipmentComment $shipmentComment
     *
     * @return JsonResponse
     */
    public function update(ShipmentCommentsRequest $request, ShipmentComment $shipmentComment): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The task was successfully updated.',

            'task' => $this->repository->updateShipmentComment($shipmentComment, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteShipmentComment($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete shipment-comment, parameters does not match.',
            ]);
        }

        $this->repository->deleteShipmentComment($id);

        return Json::sendJsonWith200([
            'message' => 'The shipment-comment was successfully deleted.',
        ]);
    }
}
