<?php

namespace App\Http\Controllers\Dashboard\TaskFiles;

use App\Helpers\Json;

use App\Models\TaskFile;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\TaskFiles as TaskFilesRequest;

use App\Logic\Dashboard\CRUD\Services\TaskFiles as TaskFilesService;

use App\Logic\Dashboard\CRUD\Repositories\TaskFiles as TaskFilesRepository;

final class Controller extends Controllers
{
    /**
     * @var TaskFilesService
     */
    protected $service;

    /**
     * @var TaskFilesRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param TaskFilesService $service
     *
     * @param TaskFilesRepository $repository
     */
    public function __construct(TaskFilesService $service, TaskFilesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param TaskFilesRequest $request
     *
     * @return JsonResponse
     */
    public function index(TaskFilesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'task-files' => $this->service->getTaskFiles($this->repository->getTaskFiles($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param TaskFilesRequest $request
     *
     * @return JsonResponse
     */
    public function store(TaskFilesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The task-file was successfully created.',

            'task-file' => $this->repository->storeTaskFile($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param TaskFile $taskFile
     *
     * @return JsonResponse
     */
    public function show(TaskFile $taskFile): JsonResponse
    {
        return Json::sendJsonWith200([
            'task-file' => $this->service->showTaskFile($taskFile),
        ]);
    }

    /**
     * @param TaskFilesRequest $request
     *
     * @param TaskFile $taskFile
     *
     * @return JsonResponse
     */
    public function update(TaskFilesRequest $request, TaskFile $taskFile): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The task-file was successfully updated.',

            'task-file' => $this->repository->updateTaskFile($taskFile, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteTaskFile($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete task-file, parameters does not match.',
            ]);
        }

        $this->repository->deleteTaskFile($id);

        return Json::sendJsonWith200([
            'message' => 'The task-file was successfully deleted.',
        ]);
    }
}
