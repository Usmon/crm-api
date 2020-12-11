<?php

namespace App\Http\Controllers\Dashboard\DeliveryComments;

use App\Helpers\Json;

use App\Models\DeliveryComment;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\DeliveryComments as DeliveryCommentsRequest;

use App\Logic\Dashboard\CRUD\Services\DeliveryComments as DeliveryCommentsService;

use App\Logic\Dashboard\CRUD\Repositories\DeliveryComments as DeliveryCommentsRepository;

final class Controller extends Controllers
{
    /**
     * @var DeliveryCommentsService
     */
    protected $service;

    /**
     * @var DeliveryCommentsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param DeliveryCommentsService $service
     *
     * @param DeliveryCommentsRepository $repository
     */
    public function __construct(DeliveryCommentsService $service, DeliveryCommentsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param DeliveryCommentsRequest $request
     *
     * @return JsonResponse
     */
    public function index(DeliveryCommentsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'delivery-comment' => $this->service->getDeliveryComments($this->repository->getDeliveryComments($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param DeliveryCommentsRequest $request
     *
     * @return JsonResponse
     */
    public function store(DeliveryCommentsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The delivery-comment was successfully created.',

            'delivery-comment' => $this->repository->storeDeliveryComment($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param DeliveryComment $deliveryComment
     *
     * @return JsonResponse
     */
    public function show(DeliveryComment $deliveryComment): JsonResponse
    {
        return Json::sendJsonWith200([
            'delivery-comment' => $this->service->showDeliveryComment($deliveryComment),
        ]);
    }

    /**
     * @param DeliveryCommentsRequest $request
     *
     * @param DeliveryComment $deliveryComment
     *
     * @return JsonResponse
     */
    public function update(DeliveryCommentsRequest $request, DeliveryComment $deliveryComment): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The delivery-comment was successfully updated.',

            'delivery-comment' => $this->repository->updateDeliveryComment($deliveryComment, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteDeliveryComment($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete delivery-comment, parameters does not match.',
            ]);
        }

        $this->repository->deleteDeliveryComment($id);

        return Json::sendJsonWith200([
            'message' => 'The delivery-comment was successfully deleted.',
        ]);
    }
}
