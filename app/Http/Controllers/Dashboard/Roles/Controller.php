<?php

namespace App\Http\Controllers\Dashboard\Roles;

use App\Models\Role;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Roles as RolesRequest;

use App\Logic\Dashboard\CRUD\Services\Roles as RolesService;

use App\Logic\Dashboard\CRUD\Repositories\Roles as RolesRepository;

use Illuminate\Http\JsonResponse;

final class Controller extends Controllers
{
    /**
     * @var RolesService
     */
    protected $service;

    /**
     * @var RolesRepository
     */
    protected $repository;

    /**
     * @param RolesService $service
     *
     * @param RolesRepository $repository
     *
     * @return void
     */
    public function __construct(RolesService $service, RolesRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param RolesRequest $request
     *
     * @return JsonResponse
     */
    public function index(RolesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'roles' => $this->service->getRoles($this->repository->getRoles($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param RolesRequest $request
     *
     * @return JsonResponse
     */
    public function store(RolesRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The role was successfully created.',

            'role' => $this->repository->storeRole($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Role $role
     *
     * @return JsonResponse
     */
    public function show(Role $role): JsonResponse
    {
        return Json::sendJsonWith200([
            'role' => $this->service->showRole($role),
        ]);
    }

    /**
     * @param RolesRequest $request
     *
     * @param Role $role
     *
     * @return JsonResponse
     */
    public function update(RolesRequest $request, Role $role): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The role was successfully updated.',

            'role' => $this->repository->updateRole($role, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param Role $role
     *
     * @return JsonResponse
     */
    public function destroy(Role $role): JsonResponse
    {
        if (! $this->repository->deleteRole($role)) {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete role, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The role was successfully deleted.',
        ]);
    }
}
