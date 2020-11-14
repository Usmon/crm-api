<?php

namespace App\Http\Controllers\Auth;

use App\Helper\Json;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\Register as RegisterRequest;

use App\Logic\Auth\Services\Register as RegisterService;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Hash;

final class Register extends Controller
{
    /**
     * @var RegisterService
     */
    protected $service;

    /**
     * @param RegisterService $service
     *
     * @return void
     */
    public function __construct(RegisterService $service)
    {
        $this->service = $service;

        $this->middleware('guest:api');
    }

    /**
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = $this->service->createUser($this->createCredentials($request));

        if (! $user) {
            return Json::sendJsonWith422([
                'errors' => [
                    'user' => [
                        'Failed to register a user, please try again later.'
                    ],
                ],
            ]);
        }

        // todo: send verify token notification.

        return Json::sendJsonWith200([
            'message' => 'The user successfully registered.',
        ]);
    }

    /**
     * @param RegisterRequest $request
     *
     * @return array
     */
    protected function createCredentials(RegisterRequest $request): array
    {
        return [
            'login' => $request->json('login'),

            'email' => $request->json('email'),

            'password' => Hash::make($request->json('password')),
        ];
    }
}
