<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Order;

use Illuminate\Contracts\Pagination\Paginator;

final class Orders
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getOrders(array $filters): Paginator
    {
        return Order::filter($filters)->orderBy('created_at', 'desc')->pager();
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
