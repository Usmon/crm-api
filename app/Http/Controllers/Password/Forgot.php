<?php

namespace App\Http\Controllers\Password;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;

use App\Logic\Password\Requests\Forgot as ForgotPasswordRequest;

use App\Logic\Password\Services\Forgot as ForgotPasswordService;

use App\Logic\Password\Repositories\Forgot as ForgotPasswordRepository;

final class Forgot extends Controller
{

    /**
     * @var ForgotPasswordService
     */
    protected $service;

    /**
     * @var ForgotPasswordRepository
     */
    protected $repository;

    /**
     * Forgot constructor.
     *
     * @param ForgotPasswordService $service
     *
     * @param ForgotPasswordRepository $repository
     */
    public function __construct(ForgotPasswordService $service, ForgotPasswordRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param ForgotPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function forgot(ForgotPasswordRequest $request): JsonResponse
    {
        $this->repository->updateUser(
            $this->service->getEmail($request), $this->service->createRandomToken(),
        );

        //todo: send token to email address

        return Json::sendJsonWith200([
            'message' => 'Successfully sent message, please check your email address.',
        ]);
    }
}
