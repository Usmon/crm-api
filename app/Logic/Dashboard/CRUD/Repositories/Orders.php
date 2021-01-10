<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Order;

use Illuminate\Contracts\Pagination\Paginator;

final class Orders
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getOrders(array $filters, array $sorts): Paginator
    {
        return Order::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Order
     */
    public function storeOrder(array $credentials): Order
    {
        $order = Order::create($credentials);

        return $order;
    }

    /**
     * @param Order $order
     *
     * @param array $credentials
     *
     * @return Order
     */
    public function updateOrder(Order $order, array $credentials): Order
    {
        $order->update($credentials);

        return $order;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteOrder($id)
    {
        return Order::destroy($id);
    }
}
