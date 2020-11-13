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
     * @var Agent
     */
    protected $agent;

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
        $this->agent = new Agent;

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
                        'These credentials do not match our records.'
                    ],
                ],
            ]);
        }

        if (! Hash::check($request->json('password'), $user->password)) {
            return Json::sendJsonWith422([
                'errors' => [
                    'password' => [
                        'The provided password is incorrect.',
                    ],
                ],
            ]);
        }

        $this->agent->setUserAgent($request->headers->get('User-Agent'));

        $device = [
            'ip' => $request->getClientIp(),
            'os' => $this->agent->platform(),
            'type' => $this->agent->deviceType(),
            'name' => $this->agent->browser() ?? $this->agent->device(),
        ];

        $token = $this->service->createTokenForUser($user, $device);

        if (! $token) {
            return Json::sendJsonWith422([
                'errors' => [
                    'login' => [
                        'Failed to create token, please try again later.',
                    ],
                ],
            ]);
        }

        return Json::sendJsonWith200([
            'token' => $token,
        ]);
    }
}
