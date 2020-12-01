<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Order;

use Illuminate\Database\Eloquent\Collection;

final class Orders
{
    /**
     * @param array $filters
     *
     * @return Collection
     */
    public function getOrders(array $filters): Collection
    {
        return Order::filter($filters)->orderBy('created_at', 'desc')->get();
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
