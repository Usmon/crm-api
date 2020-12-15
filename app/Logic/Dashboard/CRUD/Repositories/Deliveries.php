<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use Exception;

use App\Models\Delivery;

use Illuminate\Support\Arr;

use Illuminate\Contracts\Pagination\Paginator;

final class Deliveries
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getDeliveries(array $filters): Paginator
    {
        return Delivery::with(
            [
                'users'=>
                function($query){$query->select('id','login');},

                'orders'=>
                function($query){$query->select('id','customer_id');}

            ]
        )->filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $deliveryData
     *
     * @return Delivery
     */
    public function storeDelivery(array $deliveryData): Delivery
    {
        $delivery = new Delivery;

        $delivery->fill($deliveryData);

        $delivery->save();

        return $delivery;
    }

    /**
     * @param Delivery $delivery
     *
     * @param array $deliveryData
     *
     * @return Delivery
     */
    public function updateDelivery(Delivery $delivery, array $deliveryData)
    {
        $delivery->update($deliveryData);

        return $delivery;
    }

    /**
     * @param Delivery $delivery
     *
     * @return bool
     */
    public function deleteDelivery($id): bool
    {
        return Delivery::destroy($id);
    }
}
