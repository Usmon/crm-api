<?php

namespace App\Http\Controllers\Dashboard\OrderComments;

use App\Helpers\Json;

use App\Models\OrderComment;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\OrderComments as OrderCommentsRequest;

use App\Logic\Dashboard\CRUD\Services\OrderComments as OrderCommentsService;

use App\Logic\Dashboard\CRUD\Repositories\OrderComments as OrderCommentsRepository;

final class Controller extends Controllers
{
    /**
     * @var OrderCommentsService
     */
    protected $service;

    /**
     * @var OrderCommentsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param OrderCommentsService $service
     *
     * @param OrderCommentsRepository $repository
     */
    public function __construct(OrderCommentsService $service, OrderCommentsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param OrderCommentsRequest $request
     *
     * @return JsonResponse
     */
    public function index(OrderCommentsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'order-comments' => $this->service->getOrderComments($this->repository->getOrderComments($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param OrderCommentsRequest $request
     *
     * @return JsonResponse
     */
    public function store(OrderCommentsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The order-comment was successfully created.',

            'order-comment' => $this->repository->storeOrderComment($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param OrderComment $orderComment
     *
     * @return JsonResponse
     */
    public function show(OrderComment $orderComment): JsonResponse
    {
        return Json::sendJsonWith200([
            'order-comment' => $this->service->showOrderComment($orderComment),
        ]);
    }

    /**
     * @param OrderCommentsRequest $request
     *
     * @param OrderComment $orderComment
     *
     * @return JsonResponse
     */
    public function update(OrderCommentsRequest $request, OrderComment $orderComment): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The order-comment was successfully updated.',

            'order-comment' => $this->repository->updateOrderComment($orderComment, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteOrderComment($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete order-comment, parameters does not match.',
            ]);
        }

        $this->repository->deleteOrderComment($id);

        return Json::sendJsonWith200([
            'message' => 'The order-comment was successfully deleted.',
        ]);
    }
}
