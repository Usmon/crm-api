<?php

namespace App\Http\Controllers\Dashboard\Roles;

use Spatie\Permission\Models\Role;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Roles as RolesRequest;

use App\Logic\Dashboard\CRUD\Services\Roles as RolesService;

use App\Logic\Dashboard\CRUD\Repositories\Roles as RolesRepository;

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

//        $this->middleware('permission:Address111111111111111111', ['only' => ['show']]);
    }

    /**
     * @param RolesRequest $request
     *
     * @return JsonResponse
     */
    public function index(RolesRequest $request)
    {
//        if(! Gate::check('Roles')){
//            return Json::sendJsonWith403([
//                'message' =>  'Permission denied.'
//            ]);
//        }

        return Json::sendJsonWith200([
//            'filters' => $this->service->getAllFilters($request),

            'roles' => $this->repository->getRoles(),
        ]);
    }

    /**
     * @param RolesRequest $request
     *
     * @return JsonResponse
     */
    public function store(RolesRequest $request): JsonResponse
    {
//        if(! Gate::check('Roles')){
//            return Json::sendJsonWith403([
//                'message' =>  'Permission denied.'
//            ]);
//        }

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
//        if(! Gate::check('Roles')){
//            return Json::sendJsonWith403([
//                'message' =>  'Permission denied.'
//            ]);
//        }
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
//        if(! Gate::check('Roles')){
//            return Json::sendJsonWith403([
//                'message' =>  'Permission denied.'
//            ]);
//        }

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
//        if(! Gate::check('Roles')){
//            return Json::sendJsonWith403([
//                'message' =>  'Permission denied.'
//            ]);
//        }

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
