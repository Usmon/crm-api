<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Order;

use App\Models\Delivery;

final class Statuses
{
    /**
     * @return array
     */
    public function getStatusDeliveries(): array
    {
        return Delivery::STATUSES;
    }

    /**
     * @return array
     */
    public function getStatusOrders(): array
    {
        return Order::STATUSES;
    }

    /**
     * @return array
     */
    public function getPaymentStatusOrders(): array
    {
        return Order::PAYMENT_STATUSES;
    }
}
