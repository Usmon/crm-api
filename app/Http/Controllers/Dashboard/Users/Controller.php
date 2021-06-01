<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Models\User;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Users as UsersRequest;

use App\Logic\Dashboard\CRUD\Services\Users as UsersService;

use App\Logic\Dashboard\CRUD\Repositories\Users as UsersRepository;

final class Controller extends Controllers
{
    /**
     * @var UsersService
     */
    protected $service;

    /**
     * @var UsersRepository
     */
    protected $repository;

    /**
     * @param UsersService $service
     *
     * @param UsersRepository $repository
     *
     * @return void
     */
    public function __construct(UsersService $service, UsersRepository $repository)
    {
        $this->checkPermission('Users');

        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param UsersRequest $request
     *
     * @return JsonResponse
     */
    public function index(UsersRequest $request): JsonResponse
    {
        if(! Gate::check('Users')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'users' => $this->service->getUsers($this->repository->getUsers($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param UsersRequest $request
     *
     * @return JsonResponse
     */
    public function store(UsersRequest $request): JsonResponse
    {
        if(! Gate::check('Users')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The user was successfully created.',

            'user' => $this->repository->storeUser($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param User $user
     *
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        if(! Gate::check('Users')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'user' => $this->service->showUser($user),
        ]);
    }

    /**
     * @param UsersRequest $request
     *
     * @param User $user
     *
     * @return JsonResponse
     */
    public function update(UsersRequest $request, User $user): JsonResponse
    {
        if(! Gate::check('Users')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The user was successfully updated.',

            'user' => $this->repository->updateUser($user, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param User $user
     *
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        if(! Gate::check('Users')){
            return Json::sendJsonWith403([
                'message' =>  'Permission denied.'
            ]);
        }

        if (! $this->repository->deleteUser($user)) {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete user, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The user was successfully deleted.',
        ]);
    }
}
