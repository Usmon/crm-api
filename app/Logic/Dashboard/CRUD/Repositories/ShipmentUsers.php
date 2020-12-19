<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\ShipmentUser;

use Illuminate\Contracts\Pagination\Paginator;

final class ShipmentUsers
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getShipmentUsers(array $filters): Paginator
    {
        return ShipmentUser::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return ShipmentUser
     */
    public function storeShipmentUser(array $credentials): ShipmentUser
    {
        $shipmentUser = ShipmentUser::create($credentials);

        return $shipmentUser;
    }

    /**
     * @param ShipmentUser $shipmentUser
     *
     * @param array $credentials
     *
     * @return ShipmentUser
     */
    public function updateShipmentUser(ShipmentUser $shipmentUser, array $credentials): ShipmentUser
    {
        $shipmentUser->update($credentials);

        return $shipmentUser;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteShipmentUser($id)
    {
        return ShipmentUser::destroy($id);
    }
}
