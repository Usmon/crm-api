<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\ShipmentStatus;

use Illuminate\Contracts\Pagination\Paginator;

final class ShipmentStatuses
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getShipmentStatuses(array $filters, array $sorts): Paginator
    {
        return ShipmentStatus::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param int $id
     *
     * @return ShipmentStatus
     */
    public function getShipmentStatus(int $id): ShipmentStatus
    {
        return ShipmentStatus::findOrFail($id);
    }

    /**
     * @param array $credentials
     *
     * @return ShipmentStatus
     */
    public function storeShipmentStatus(array $credentials): ShipmentStatus
    {
        $shipmentStatus = ShipmentStatus::create($credentials);

        return $shipmentStatus;
    }


    /**
     * @param ShipmentStatus $shipmentStatus
     *
     * @param array $credentials
     *
     * @return ShipmentStatus
     */
    public function updateShipmentStatus(ShipmentStatus $shipmentStatus, array $credentials): ShipmentStatus
    {

        $shipmentStatus->update($credentials);

        return $shipmentStatus;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteShipmentStatus($id): int
    {
        return ShipmentStatus::destroy($id);
    }
}
