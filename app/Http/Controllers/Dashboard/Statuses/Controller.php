<?php

namespace App\Http\Controllers\Dashboard\Statuses;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Repositories\Statuses as StatusesRepository;

final class Controller extends Controllers
{
    /**
     * @var StatusesRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param StatusesRepository $repository
     */
    public function __construct(StatusesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return JsonResponse
     */
    public function statusDeliveries(): JsonResponse
    {
        return Json::sendJsonWith200([
            'statuses' => $this->repository->getStatusDeliveries(),
        ]);
    }
}
