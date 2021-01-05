<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Delivery;

use Illuminate\Contracts\Pagination\Paginator;

final class Deliveries
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getDeliveries(array $filters, array $sorts): Paginator
    {
        return Delivery::filter($filters)->sort($sorts)->pager();
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
