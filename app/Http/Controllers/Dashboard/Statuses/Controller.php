<?php

namespace App\Http\Controllers\Dashboard\Statuses;

use App\Helpers\Json;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Services\Statuses as StatusesService;

final class Controller extends Controllers
{
    /**
     * @var StatusesService
     */
    protected $service;

    /**
     * Controller constructor.
     *
     * @param StatusesService $service
     */
    public function __construct(StatusesService $service)
    {
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function statusDeliveries(): JsonResponse
    {
        return Json::sendJsonWith200([
            'statuses' => $this->service->getStatusDeliveries(),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function statusOrders(): JsonResponse
    {
        return Json::sendJsonWith200([
            'statuses' => $this->service->getStatusOrders(),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function statusPaymentOrders(): JsonResponse
    {
        return Json::sendJsonWith200([
            'payment_statuses' => $this->service->getPaymentStatusOrders(),
        ]);
    }

    public function statusShipments(): JsonResponse
    {
        return Json::sendJsonWith200([
            'statuses' => $this->service->getStatusShipments(),
        ]);
    }
}
