<?php

namespace App\Http\Controllers\Dashboard\TaskSteps;

use App\Helpers\Json;

use App\Models\TaskStep;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\TaskSteps as TaskStepsRequest;

use App\Logic\Dashboard\CRUD\Services\TaskSteps as TaskStepsService;

use App\Logic\Dashboard\CRUD\Repositories\TaskSteps as TaskStepsRepository;


final class Controller extends Controllers
{
    /**
     * @var TaskStepsService
     */
    protected $service;

    /**
     * @var TaskStepsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param TaskStepsService $service
     *
     * @param TaskStepsRepository $repository
     */
    public function __construct(TaskStepsService $service, TaskStepsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param TaskStepsRequest $request
     *
     * @return JsonResponse
     */
    public function index(TaskStepsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'task-steps' => $this->service->getTaskSteps($this->repository->getTaskSteps($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param TaskStepsRequest $request
     *
     * @return JsonResponse
     */
    public function store(TaskStepsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The task-step was successfully created.',

            'task-step' => $this->repository->storeTaskStep($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param TaskStep $taskStep
     *
     * @return JsonResponse
     */
    public function show(TaskStep $taskStep): JsonResponse
    {
        return Json::sendJsonWith200([
            'task-step' => $this->service->showTaskStep($taskStep),
        ]);
    }

    /**
     * @param TaskStepsRequest $request
     *
     * @param TaskStep $taskStep
     *
     * @return JsonResponse
     */
    public function update(TaskStepsRequest $request, TaskStep $taskStep): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The task-step was successfully updated.',

            'task-step' => $this->repository->updateTaskStep($taskStep, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteTaskStep($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete task-step, parameters does not match.',
            ]);
        }

        $this->repository->deleteTaskStep($id);

        return Json::sendJsonWith200([
            'message' => 'The task-step was successfully deleted.',
        ]);
    }
}
