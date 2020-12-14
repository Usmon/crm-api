<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\OrderUser;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\OrderUsers as OrderUsersRequest;

final class OrderUsers
{
    /**
     * @param OrderUsersRequest $request
     *
     * @return array
     */
    public function getAllFilters(OrderUsersRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'user_id' => $request->json('user_id'),

            'order_id' => $request->json('order_id'),
        ];
    }

    /**
     * @param OrderUsersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(OrderUsersRequest $request): array
    {
        return $request->only('search', 'date', 'user_id', 'order_id');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getOrderUsers(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (OrderUser $orderUser) {
            return [
                'id' => $orderUser->id,

                'user_id' => $orderUser->user_id,

                'order_id' => $orderUser->order_id,

                'created_at' => $orderUser->created_at,

                'updated_at' => $orderUser->updated_at,

                'user' => $orderUser->user,

                'order' => $orderUser->order,
            ];
        });
        return $paginator;
    }

    /**
     * @param OrderUser $orderUser
     *
     * @return array
     */
    public function showOrderUser(OrderUser $orderUser): array
    {
        return [
            'id' => $orderUser->id,

            'user_id' => $orderUser->user_id,

            'order_id' => $orderUser->order_id,

            'created_at' => $orderUser->created_at,

            'updated_at' => $orderUser->updated_at,

            'user' => $orderUser->user,

            'order' => $orderUser->order,
        ];
    }

    /**
     * @param OrderUsersRequest $request
     *
     * @return array
     */
    public function storeCredentials(OrderUsersRequest $request): array
    {
        return [
            'order_id' => $request->json('order_id'),

            'user_id' => $request->json('user_id'),
        ];
    }

    /**
     * @param OrderUsersRequest $request
     *
     * @return array
     */
    public function updateCredentials(OrderUsersRequest $request): array
    {
        $credentials = [
            'order_id' => $request->json('order_id'),

            'user_id' => $request->json('user_id'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteOrderUser($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
