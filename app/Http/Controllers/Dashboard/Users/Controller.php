<?php

namespace App\Http\Controllers\Dashboard\Users;

use App\Models\User;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\Users as UsersRequest;

use App\Logic\Dashboard\CRUD\Services\Users as UsersService;

use App\Logic\Dashboard\CRUD\Repositories\Users as UsersRepository;

use Illuminate\Http\JsonResponse;

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