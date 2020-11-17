<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Json;

use App\Http\Controllers\Controller;

use App\Logic\Auth\Requests\Logout as LogoutRequest;

use App\Logic\Auth\Services\Logout as LogoutService;

use App\Logic\Auth\Repositories\Logout as LogoutRepository;

use Illuminate\Http\JsonResponse;

final class Logout extends Controller
{
    /**
     * @var LogoutService
     */
    protected $service;

    /**
     * @var LogoutRepository
     */
    protected $repository;

    /**
     * @param LogoutService $service
     *
     * @param LogoutRepository $repository
     *
     * @return void
     */
    public function __construct(LogoutService $service, LogoutRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;

        $this->middleware('auth:api');
    }

    /**
     * @param LogoutRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(LogoutRequest $request): JsonResponse
    {
        $user = $this->service->getUser($request);

        if (! $user) {
            return Json::sendJsonWith401([
                'message' => 'You are not authorized.',
            ]);
        }

        $token = $this->service->getBearerToken($request);

        if (! $token) {
            return Json::sendJsonWith401([
                'message' => 'You are not authorized.',
            ]);
        }

        if (! $this->repository->deleteToken($user, $token)) {
            return Json::sendJsonWith409([
                'message' => 'Failed to logged out, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The user successfully logged out.',
        ]);
    }
}
