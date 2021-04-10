<?php

namespace App\Http\Controllers\Dashboard\Orders\Limit;

use App\Helpers\Json;

use App\Helpers\LimitChecker;

use Illuminate\Http\JsonResponse;

use App\Logic\Dashboard\CRUD\Requests\Limit as LimitRequest;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Services\Orders as OrdersService;

use App\Logic\Dashboard\CRUD\Repositories\Orders as OrdersRepository;

/**
 * Class Controller
 *
 * @package App\Http\Controllers\Dashboard\Orders\Limit
 */
class Controller extends Controllers
{

    /**
     * @var OrdersService
     */
    protected $service;

    /**
     * @var OrdersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param OrdersService $service
     *
     * @param OrdersRepository $repository
     */
    public function __construct(OrdersService $service, OrdersRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param LimitRequest $request
     *
     * @return JsonResponse
     */
    public function checkSender(LimitRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'data' => $this->service->recipientLimit((new LimitChecker())->limit('recipient_id', $this->service->getRecipient($request)))
        ]);
    }
}
