<?php

namespace App\Http\Controllers\Dashboard\Feedbacks;

use App\Helpers\Json;

use App\Models\Feedback;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Feedbacks as FeedbacksRequest;

use App\Logic\Dashboard\CRUD\Services\Feedbacks as FeedbacksService;

use App\Logic\Dashboard\CRUD\Repositories\Feedbacks as FeedbacksRepository;

final class Controller extends Controllers
{
    /**
     * @var FeedbacksService
     */
    protected $service;

    /**
     * @var FeedbacksRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param FeedbacksService $service
     *
     * @param FeedbacksRepository $repository
     */
    public function __construct(FeedbacksService $service, FeedbacksRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param FeedbacksRequest $request
     *
     * @return JsonResponse
     */
    public function index(FeedbacksRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'feedbacks' => $this->service->getFeedbacks($this->repository->getFeedbacks($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param FeedbacksRequest $request
     *
     * @return JsonResponse
     */
    public function store(FeedbacksRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The feedback was successfully created.',

            'feedback' => $this->repository->storeFeedback($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Feedback $feedback
     *
     * @return JsonResponse
     */
    public function show(Feedback $feedback): JsonResponse
    {
        return Json::sendJsonWith200([
            'feedback' => $this->service->showFeedback($feedback),
        ]);
    }

    /**
     * @param FeedbacksRequest $request
     *
     * @param Feedback $feedback
     *
     * @return JsonResponse
     */
    public function update(FeedbacksRequest $request, Feedback $feedback): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The feedback was successfully updated.',

            'feedback' => $this->repository->updateFeedback($feedback, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteFeedback($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete feedback, parameters does not match.',
            ]);
        }

        $this->repository->deleteFeedback($id);

        return Json::sendJsonWith200([
            'message' => 'The feedback was successfully deleted.',
        ]);
    }
}
