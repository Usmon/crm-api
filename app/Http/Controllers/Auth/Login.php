<?php

namespace App\Http\Controllers\Auth;

use App\Helper\Json;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\Login as LoginRequest;

use App\Logic\Auth\Services\Login as LoginService;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Hash;

use Jenssegers\Agent\Agent;

final class Login extends Controller
{
    /**
     * @var LoginService
     */
    protected $service;

    /**
     * @param LoginService $service
     *
     * @return void
     */
    public function __construct(LoginService $service)
    {
        $this->service = $service;

        $this->middleware('guest:api');
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = $this->service->getUserByLogin($request->json('login'));

        if (! $user) {
            return Json::sendJsonWith422([
                'errors' => [
                    'login' => [
                        'The provided login was not found.'
                    ],
                ],
            ]);
        }

        $check = Hash::check($request->json('password'), $user->password);

        if (! $check) {
            return Json::sendJsonWith422([
                'errors' => [
                    'password' => [
                        'The provided password is incorrect.',
                    ],
                ],
            ]);
        }

        $token = $this->service->createTokenForUser($user, $this->createDevice($request));

        if (! $token) {
            return Json::sendJsonWith422([
                'errors' => [
                    'token' => [
                        'Failed to create a token, please try again later.',
                    ],
                ],
            ]);
        }

        return Json::sendJsonWith200([
            'token' => $token,
        ]);
    }

    /**
     * @param LoginRequest $request
     *
     * @return array
     */
    protected function createDevice(LoginRequest $request): array
    {
        $agent = new Agent;

        $agent->setUserAgent($request->userAgent());

        return [
            'ip' => $request->ip(),

            'os' => $agent->platform(),

            'type' => $agent->deviceType(),

            'name' => $agent->browser() ?? $agent->device(),
        ];
    }
}
