<?php

namespace App\Http\Controllers\Dashboard\Projects;

use App\Helpers\Json;

use App\Models\Project;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Projects as ProjectsRequest;

use App\Logic\Dashboard\CRUD\Services\Projects as ProjectsService;

use App\Logic\Dashboard\CRUD\Repositories\Projects as ProjectsRepository;

final class Controller extends Controllers
{
    /**
     * @var ProjectsService
     */
    protected $service;

    /**
     * @var ProjectsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param ProjectsService $service
     *
     * @param ProjectsRepository $repository
     */
    public function __construct(ProjectsService $service, ProjectsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param ProjectsRequest $request
     *
     * @return JsonResponse
     */
    public function index(ProjectsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'projects' => $this->service->getProjects($this->repository->getProjects($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param ProjectsRequest $request
     *
     * @return JsonResponse
     */
    public function store(ProjectsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The project was successfully created.',

            'project' => $this->repository->storeProject($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Project $project
     *
     * @return JsonResponse
     */
    public function show(Project $project): JsonResponse
    {
        return Json::sendJsonWith200([
            'project' => $this->service->showProject($project),
        ]);
    }

    /**
     * @param ProjectsRequest $request
     *
     * @param Project $project
     *
     * @return JsonResponse
     */
    public function update(ProjectsRequest $request, Project $project): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The project was successfully updated.',

            'project' => $this->repository->updateProject($project, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $id = $this->service->deleteProject($id);

        if(!$id){
            return Json::sendJsonWith409([
                'message' => 'Failed to delete project, parameters does not match.',
            ]);
        }

        $this->repository->deleteProject($id);

        return Json::sendJsonWith200([
            'message' => 'The project was successfully deleted.',
        ]);
    }
}
