<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Json;

use App\Http\Controllers\Controller;

use App\Logic\Auth\Requests\Login as LoginRequest;

use App\Logic\Auth\Services\Login as LoginService;

use App\Logic\Auth\Repositories\Login as LoginRepository;

use Illuminate\Http\JsonResponse;

final class Login extends Controller
{
    /**
     * @var LoginService
     */
    protected $service;

    /**
     * @var LoginRepository
     */
    protected $repository;

    /**
     * @param LoginService $service
     *
     * @param LoginRepository $repository
     *
     * @return void
     */
    public function __construct(LoginService $service, LoginRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;

        $this->middleware('guest:api');
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $credentials = $this->service->createCredentials($request);

        $user = $this->repository->getUser('login', $credentials['login']) ?? $this->repository->getUser('email', $credentials['email']);

        if (! $user) {
            return Json::sendJsonWith404([
                'message' => 'The user with these credentials was not found.',
            ]);
        }

        if (! $this->service->checkPassword($user, $credentials['password'])) {
            return Json::sendJsonWith422([
                'message' => [
                    'password' => [
                        'The provided password is incorrect.',
                    ],
                ],
            ]);
        }

        $token = $this->repository->createToken($user, $this->service->createDevice($request));

        if (! $token) {
            return Json::sendJsonWith409([
                'message' => 'Failed to create a token, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'token' => $token->value,
        ]);
    }
}
