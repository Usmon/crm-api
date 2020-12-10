<?php

namespace App\Http\Controllers\Dashboard\TaskUsers;

use App\Helpers\Json;

use App\Models\TaskUser;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\TaskUsers as TaskUsersRequest;

use App\Logic\Dashboard\CRUD\Services\TaskUsers as TaskUsersService;

use App\Logic\Dashboard\CRUD\Repositories\TaskUsers as TaskUsersRepository;

final class Controller extends Controllers
{
    /**
     * @var TaskUsersService
     */
    protected $service;

    /**
     * @var TaskUsersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param TaskUsersService $service
     *
     * @param TaskUsersRepository $repository
     */
    public function __construct(TaskUsersService $service, TaskUsersRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param TaskUsersRequest $request
     *
     * @return JsonResponse
     */
    public function index(TaskUsersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'task-users' => $this->service->getTaskUsers($this->repository->getTaskUsers($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param TaskUsersRequest $request
     *
     * @return JsonResponse
     */
    public function store(TaskUsersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The task-user was successfully created.',

            'task-user' => $this->repository->storeTaskUser($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param TaskUser $taskUser
     *
     * @return JsonResponse
     */
    public function show(TaskUser $taskUser): JsonResponse
    {
        return Json::sendJsonWith200([
            'task-user' => $this->service->showTaskUser($taskUser),
        ]);
    }

    /**
     * @param TaskUsersRequest $request
     *
     * @param TaskUser $taskUser
     *
     * @return JsonResponse
     */
    public function update(TaskUsersRequest $request, TaskUser $taskUser): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The task-user was successfully updated.',

            'task-user' => $this->repository->updateTaskUser($taskUser, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteTaskUser($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete task-user, parameters does not match.',
            ]);
        }

        $this->repository->deleteTaskUser($id);

        return Json::sendJsonWith200([
            'message' => 'The task-user was successfully deleted.',
        ]);
    }
}
