<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\DeliveryUser;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\DeliveryUsers as DeliveryUsersRequest;

final class DeliveryUsers
{
    /**
     * @param DeliveryUsersRequest $request
     *
     * @return array
     */
    public function getAllFilters(DeliveryUsersRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'delivery_id' => $request->json('delivery_id'),

            'user_id' => $request->json('user_id'),
        ];
    }

    /**
     * @param DeliveryUsersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(DeliveryUsersRequest $request): array
    {
        return $request->only('search', 'date', 'user_id', 'delivery_id');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getDeliveryUsers(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (DeliveryUser $deliveryUser) {
            return [
                'id' => $deliveryUser->id,

                'user_id' => $deliveryUser->user_id,

                'delivery_id' => $deliveryUser->delivery_id,

                'created_at' => $deliveryUser->created_at,

                'updated_at' => $deliveryUser->updated_at,

                'user' => $deliveryUser->user,

                'delivery' => $deliveryUser->delivery,
            ];
        });
        return $paginator;
    }

    /**
     * @param DeliveryUser $deliveryUser
     *
     * @return array
     */
    public function showDeliveryUser(DeliveryUser $deliveryUser): array
    {
        return [
            'id' => $deliveryUser->id,

            'user_id' => $deliveryUser->user_id,

            'delivery_id' => $deliveryUser->delivery_id,

            'created_at' => $deliveryUser->created_at,

            'updated_at' => $deliveryUser->updated_at,

            'user' => $deliveryUser->user,

            'delivery' => $deliveryUser->delivery,
        ];
    }

    /**
     * @param DeliveryUsersRequest $request
     *
     * @return array
     */
    public function storeCredentials(DeliveryUsersRequest $request): array
    {
        return [
            'user_id' => $request->json('user_id'),

            'delivery_id' => $request->json('delivery_id'),
        ];
    }

    /**
     * @param DeliveryUsersRequest $request
     *
     * @return array
     */
    public function updateCredentials(DeliveryUsersRequest $request): array
    {
        $credentials = [
            'user_id' => $request->json('user_id'),

            'delivery_id' => $request->json('delivery_id'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteDeliveryUser($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
