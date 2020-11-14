<?php

namespace App\Http\Controllers\Auth;

use Exception;

use App\Helper\Json;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\Logout as LogoutRequest;

use App\Logic\Auth\Services\Logout as LogoutService;

use Illuminate\Http\JsonResponse;

final class Logout extends Controller
{
    /**
     * @var LogoutService
     */
    protected $service;

    /**
     * @param LogoutService $service
     *
     * @return void
     */
    public function __construct(LogoutService $service)
    {
        $this->service = $service;

        $this->middleware('auth:api');
    }

    /**
     * @param LogoutRequest $request
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function __invoke(LogoutRequest $request): JsonResponse
    {
        $token = $this->service->deleteUserToken($request->user(), $request->bearerToken());

        if (! $token) {
            return Json::sendJsonWith422([
                'errors' => [
                    'token' => [
                        'Failed to logout a user, please try again later.'
                    ],
                ],
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The user successfully logged out.',
        ]);
    }
}
