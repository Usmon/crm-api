<?php

namespace App\Http\Controllers\Password;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;

use App\Logic\Password\Requests\Token as TokenRequest;

use App\Logic\Password\Requests\Reset as ResetPasswordRequest;

use App\Logic\Password\Services\Reset as ResetPasswordService;

use App\Logic\Password\Repositories\Reset as ResetPasswordRepository;

final class Reset extends Controller
{
    /**
     * @var ResetPasswordService
     */
    protected $service;
    /**
     * @var ResetPasswordRepository
     */
    protected $repository;

    /**
     * Reset constructor.
     *
     * @param ResetPasswordService $service
     *
     * @param ResetPasswordRepository $repository
     */
    public function __construct(ResetPasswordService $service, ResetPasswordRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param TokenRequest $token
     *
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function reset(TokenRequest $token, ResetPasswordRequest $request): JsonResponse
    {
        $this->repository->updateUser(
            $this->service->getProperties($token, $request)
        );

        return Json::sendJsonWith200([
            'message' =>'Successfully updated password.',
        ]);
    }
}
