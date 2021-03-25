<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Box;
use Exception;

use App\Models\Shipment;

use Illuminate\Contracts\Pagination\Paginator;

final class Shipments
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getShipments(array $filters, array $sorts): Paginator
    {
        return Shipment::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Shipment
     */
    public function storeShipment(array $credentials): Shipment
    {
        $shipment = Shipment::create($credentials);

        self::attachBoxes($credentials['boxes'], $shipment->id);

        return $shipment;
    }

    /**
     * @param Shipment $shipment
     *
     * @param array $credentials
     *
     * @return Shipment
     */
    public function updateShipment(Shipment $shipment, array $credentials): Shipment
    {
        $shipment->update($credentials);

        return $shipment;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function deleteShipment($id): bool
    {
        $id = json_decode($id);
        try {
            Shipment::destroy($id);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function attachBoxes(array $boxesId, $shipmentId)
    {
        foreach ($boxesId as $id)
        {
            Box::find($id)->update([
                'shipment_id' => $shipmentId,
            ]);
        }
    }
}
