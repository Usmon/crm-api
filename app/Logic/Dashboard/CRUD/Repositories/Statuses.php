<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

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
}
