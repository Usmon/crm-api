<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Shipment;

use Exception;

use Illuminate\Database\Eloquent\Collection;

final class Shipments
{
    /**
     * @param array $filters
     *
     * @return Collection
     */
    public function getShipments(array $filters): Collection
    {
        return Shipment::filter($filters)->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param array $credentials
     *
     * @return Shipment
     */
    public function storeShipment(array $credentials): Shipment
    {
        $shipment = Shipment::create($credentials);

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
            if(is_array($id)){
                Shipment::destroy($id);
            }
            else{
                $shipment = Shipment::findOrFail($id);
                $shipment->delete();
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
