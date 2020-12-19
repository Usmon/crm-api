<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\OrderUser;

use Illuminate\Contracts\Pagination\Paginator;

final class OrderUsers
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getOrderUsers(array $filters): Paginator
    {
        return OrderUser::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return OrderUser
     */
    public function storeOrderUser(array $credentials): OrderUser
    {
        $orderUser = OrderUser::create($credentials);

        return $orderUser;
    }

    /**
     * @param OrderUser $orderUser
     *
     * @param array $credentials
     *
     * @return OrderUser
     */
    public function updateOrderUser(OrderUser $orderUser, array $credentials): OrderUser
    {
        $orderUser->update($credentials);

        return $orderUser;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteOrderUser($id)
    {
        return OrderUser::destroy($id);
    }
}
