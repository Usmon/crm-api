<?php

namespace App\Http\Controllers\User\Sessions;

use App\Models\Token;

use App\Helpers\Json;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\User\Services\Sessions as SessionsService;

use App\Logic\User\Repositories\Sessions as SessionsRepository;

use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;

class Controller extends Controllers
{
    /**
     * @var SessionsService
     */
    protected $service;

    /**
     * @var SessionsRepository
     */
    protected $repository;

    /**
     * @param SessionsService $service
     *
     * @param SessionsRepository $repository
     *
     * @return void
     */
    public function __construct(SessionsService $service, SessionsRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'sessions' => $this->service->getSessions($this->repository->getSessions($this->service->getUser($request)), $this->service->getBearerToken($request)),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function deleteOther(Request $request): JsonResponse
    {
        $this->repository->deleteOtherSessions($this->service->getUser($request), $this->service->getBearerToken($request));

        return Json::sendJsonWith200([
            'message' => 'The other sessions successfully deleted.',
        ]);
    }

    /**
     * @param Request $request
     *
     * @param Token $token
     *
     * @return JsonResponse
     */
    public function delete(Request $request, Token $token): JsonResponse
    {
        if (! $this->repository->deleteSession($this->service->getUser($request), $token)) {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete session, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The session successfully deleted.',
        ]);
    }
}
