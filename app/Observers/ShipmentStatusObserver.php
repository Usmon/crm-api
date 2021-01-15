<?php

namespace App\Observers;

use App\Models\ShipmentStatus;

use Illuminate\Support\Carbon;

final class ShipmentStatusObserver
{
    /**
     * @param ShipmentStatus $shipmentStatus
     *
     * @return void
     */
    public function creating(ShipmentStatus $shipmentStatus): void
    {
        $this->defaultProperties($shipmentStatus);
    }

    /**
     * @param ShipmentStatus $shipmentStatus
     *
     * @return void
     */
    public function updating(ShipmentStatus $shipmentStatus): void
    {
        $this->defaultProperties($shipmentStatus);
    }

    /**
     * @param ShipmentStatus $shipmentStatus
     *
     * @return void
     */
    public function deleting(ShipmentStatus $shipmentStatus): void
    {
        $shipmentStatus->deleted_at = $shipmentStatus->deleted_at ?? Carbon::now();
    }

    /**
     * @param ShipmentStatus $shipmentStatus
     *
     * @return void
     */
    public function restoring(ShipmentStatus $shipmentStatus): void
    {
        $shipmentStatus->deleted_at = null;
    }

    /**
     * @param ShipmentStatus $shipmentStatus
     *
     * @return void
     */
    protected function defaultProperties(ShipmentStatus $shipmentStatus): void
    {
        $shipmentStatus->color = $shipmentStatus->color ?? ShipmentStatus::DEFAULT_COLOR;

        $shipmentStatus->created_at = $shipmentStatus->created_at ?? Carbon::now();

        $shipmentStatus->updated_at = $shipmentStatus->updated_at ?? Carbon::now();

        $shipmentStatus->deleted_at = $shipmentStatus->deleted_at ?? null;
    }
}
