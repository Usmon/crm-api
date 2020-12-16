<?php

namespace App\Observers;

use App\Models\ShipmentUser;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class ShipmentUserObserver
{
    /**
     * @param ShipmentUser $shipmentUser
     *
     * @return void
     */
    public function creating(ShipmentUser $shipmentUser): void
    {
        $this->defaultProperties($shipmentUser);
    }

    /**
     * @param ShipmentUser $shipmentUser
     *
     * @return void
     */
    public function updating(ShipmentUser $shipmentUser): void
    {
        $this->defaultProperties($shipmentUser);
    }

    /**
     * @param ShipmentUser $shipmentUser
     *
     * @return void
     */
    public function deleting(ShipmentUser $shipmentUser): void
    {
        $shipmentUser->deleted_by = $shipmentUser->deleted_by ?? Auth::id();

        $shipmentUser->deleted_at = $shipmentUser->deleted_at ?? Carbon::now();

        $shipmentUser->update();
    }

    /**
     * @param ShipmentUser $shipmentUser
     *
     * @return void
     */
    public function restoring(ShipmentUser $shipmentUser): void
    {
        $shipmentUser->deleted_at = null;
    }

    /**
     * @param ShipmentUser $shipmentUser
     *
     * @return void
     */
    protected function defaultProperties(ShipmentUser $shipmentUser): void
    {
        $shipmentUser->created_at = $shipmentUser->created_at ?? Carbon::now();

        $shipmentUser->updated_at = $shipmentUser->updated_at ?? Carbon::now();

        $shipmentUser->deleted_at = $shipmentUser->deleted_at ?? null;

        $shipmentUser->deleted_by = $shipmentUser->deleted_by ?? null;
    }
}
