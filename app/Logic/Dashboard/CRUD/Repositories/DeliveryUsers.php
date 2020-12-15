<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\DeliveryUser;

use Illuminate\Contracts\Pagination\Paginator;

final class DeliveryUsers
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getDeliveryUsers(array $filters): Paginator
    {
        return DeliveryUser::with(['user','delivery'])->filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return DeliveryUser
     */
    public function storeDeliveryUser(array $credentials): DeliveryUser
    {
        $deliveryUser = DeliveryUser::create($credentials);

        return $deliveryUser;
    }

    /**
     * @param DeliveryUser $deliveryUser
     *
     * @param array $credentials
     *
     * @return DeliveryUser
     */
    public function updateDeliveryUser(DeliveryUser $deliveryUser, array $credentials): DeliveryUser
    {
        $deliveryUser->update($credentials);

        return $deliveryUser;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteDeliveryUser($id)
    {
        return DeliveryUser::destroy($id);
    }
}
