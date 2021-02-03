<?php

namespace App\Http\Controllers\Password;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;

use App\Logic\Password\Requests\Reset as ResetPasswordRequest;

use App\Logic\Password\Services\Reset as ResetPasswordService;

use App\Logic\Password\Repositories\Reset as ResetPasswordRepository;

final class Reset extends Controller
{
    protected $service;

    protected $repository;

    public function __construct(ResetPasswordService $service, ResetPasswordRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $this->repository->updateUser(
            $this->service->getToken($request), $this->service->getPassword($request)
        );

        return Json::sendJsonWith200([
            'message' =>'Successfully updated password.',
        ]);
    }
}
