<?php

namespace App\Observers;

use App\Models\Shipment;

use Illuminate\Support\Carbon;

final class ShipmentObserver
{
    /**
     * @param Shipment $shipment
     */
    public function creating(Shipment $shipment): void
    {
        $this->defaultProperties($shipment);
    }

    /**
     * @param Shipment $shipment
     */
    public function updating(Shipment $shipment): void
    {
        $this->defaultProperties($shipment);
    }

    /**
     * @param Shipment $shipment
     */
    public function deleting(Shipment $shipment): void
    {
        $shipment->deleted_at = $shipment->deleted_at ?? Carbon::now();
    }

    /**
     * @param Shipment $shipment
     */
    public function restoring(Shipment $shipment): void
    {
        $shipment->deleted_at = null;
    }

    /**
     * @param Shipment $shipment
     */
    protected function defaultProperties(Shipment $shipment): void
    {
        $shipment->created_at = $shipment->created_at ?? Carbon::now();

        $shipment->updated_at = $shipment->updated_at ?? Carbon::now();

        $shipment->deleted_at = $shipment->deleted_at ?? null;
    }

    /**
     * @param Shipment $shipment
     */
    public function afterAddedOrUpdatedOrDeletedBoxProperties(Shipment $shipment): void
    {
        $shipment->total_boxes = $shipment->getTotalBoxesAttribute();

        $shipment->total_weight_boxes = $shipment->getTotalWeightBoxesAttribute();

        $shipment->total_price_orders = $shipment->getTotalPriceOrdersAttribute();

        $shipment->update();
    }
}
