<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Json;

use App\Http\Controllers\Controller;

use App\Logic\Auth\Requests\Register as RegisterRequest;

use App\Logic\Auth\Services\Register as RegisterService;

use App\Logic\Auth\Repositories\Register as RegisterRepository;

use Illuminate\Http\JsonResponse;

final class Register extends Controller
{
    /**
     * @var RegisterService
     */
    protected $service;

    /**
     * @var RegisterRepository
     */
    protected $repository;

    /**
     * @param RegisterService $service
     *
     * @param RegisterRepository $repository
     *
     * @return void
     */
    public function __construct(RegisterService $service, RegisterRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;

        $this->middleware('guest:api');
    }

    /**
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        if (! $this->repository->createUser($this->service->createCredentials($request))) {
            return Json::sendJsonWith409([
                'message' => 'Registration failed, please try again later.',
            ]);
        }

        // todo: send verify token notification.

        return Json::sendJsonWith200([
            'message' => 'You have successfully registered.',
        ]);
    }
}
