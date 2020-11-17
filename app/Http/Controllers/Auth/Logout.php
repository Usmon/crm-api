<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Json;

use App\Http\Controllers\Controller;

use App\Logic\Auth\Services\Logout as LogoutService;

use App\Logic\Auth\Repositories\Logout as LogoutRepository;

use Illuminate\Http\Request;

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
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        if (! $this->repository->deleteToken($this->service->getUser($request), $this->service->getBearerToken($request))) {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete session, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'You have successfully logged out.',
        ]);
    }
}
