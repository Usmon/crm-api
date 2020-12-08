<?php

namespace App\Http\Controllers\Dashboard\Tasks;

use App\Models\Task;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Tasks as TasksRequest;

use App\Logic\Dashboard\CRUD\Services\Tasks as TasksService;

use App\Logic\Dashboard\CRUD\Repositories\Tasks as TasksRepository;

final class Controller extends Controllers
{
    /**
     * @var TasksService
     */
    protected $service;

    /**
     * @var TasksRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param TasksService $service
     *
     * @param TasksRepository $repository
     */
    public function __construct(TasksService $service, TasksRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param TasksRequest $request
     *
     * @return JsonResponse
     */
    public function index(TasksRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'tasks' => $this->service->getTasks($this->repository->getTasks($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param TasksRequest $request
     *
     * @return JsonResponse
     */
    public function store(TasksRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The task was successfully created.',

            'task' => $this->repository->storeTask($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Task $task
     *
     * @return JsonResponse
     */
    public function show(Task $task): JsonResponse
    {
        return Json::sendJsonWith200([
            'task' => $this->service->showTask($task),
        ]);
    }

    /**
     * @param TasksRequest $request
     *
     * @param Task $task
     *
     * @return JsonResponse
     */
    public function update(TasksRequest $request, Task $task): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The task was successfully updated.',

            'task' => $this->repository->updateTask($task, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteTask($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete task, parameters does not match.',
            ]);
        }

        $this->repository->deleteTask($id);

        return Json::sendJsonWith200([
            'message' => 'The task was successfully deleted.',
        ]);
    }
}
