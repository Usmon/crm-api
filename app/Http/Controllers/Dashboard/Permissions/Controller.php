<?php

namespace App\Http\Controllers\Dashboard\Permissions;

use Spatie\Permission\Models\Permission;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Permissions as PermissionsRequest;

use App\Logic\Dashboard\CRUD\Services\Permissions as PermissionsService;

use App\Logic\Dashboard\CRUD\Repositories\Permissions as PermissionsRepository;

final class Controller extends Controllers
{
    /**
     * @var PermissionsService
     */
    protected $service;

    /**
     * @var PermissionsRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     * @param PermissionsService $service
     * @param PermissionsRepository $repository
     */
    public function __construct(PermissionsService $service, PermissionsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param PermissionsRequest $request
     * @return JsonResponse
     */
    public function index(PermissionsRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'roles' => $this->service->getPermissions($this->repository->getPermissions($this->service->getOnlyFilters($request), $this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param PermissionsRequest $request
     * @return JsonResponse
     */
    public function store(PermissionsRequest $request): JsonResponse
    {
//        if(! Gate::check('Roles')){
//            return Json::sendJsonWith403([
//                'message' =>  'Permission denied.'
//            ]);
//        }

        return Json::sendJsonWith200([
            'message' => 'The permission was successfully created.',

            'role' => $this->repository->storePermission($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param Permission $permission
     *
     * @return JsonResponse
     */
    public function show(Permission $permission): JsonResponse
    {
//        if(! Gate::check('Roles')){
//            return Json::sendJsonWith403([
//                'message' =>  'Permission denied.'
//            ]);
//        }
        return Json::sendJsonWith200([
            'permission' => $this->service->showPermission($permission),
        ]);
    }

    /**
     * @param PermissionsRequest $request
     * @param Permission $permission
     * @return JsonResponse
     */
    public function update(PermissionsRequest $request, Permission $permission): JsonResponse
    {
//        if(! Gate::check('Roles')){
//            return Json::sendJsonWith403([
//                'message' =>  'Permission denied.'
//            ]);
//        }

        return Json::sendJsonWith200([
            'message' => 'The permission was successfully updated.',

            'permission' => $this->repository->updatePermission($permission, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param Permission $permission
     *
     * @return JsonResponse
     */
    public function destroy(Permission $permission): JsonResponse
    {
//        if(! Gate::check('Roles')){
//            return Json::sendJsonWith403([
//                'message' =>  'Permission denied.'
//            ]);
//        }

        if (! $this->repository->deletePermission($permission)) {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete permission, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The permission was successfully deleted.',
        ]);
    }
}
