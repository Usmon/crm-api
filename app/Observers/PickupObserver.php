<?php

namespace App\Observers;

use App\Models\Pickup;

use Illuminate\Support\Str;

use Illuminate\Support\Carbon;

final class PickupObserver
{
    /**
     * @param Pickup $pickup
     *
     * @return void
     */
    public function creating(Pickup $pickup): void
    {
        $this->defaultProperties($pickup);
    }

    /**
     * @param Pickup $pickup
     *
     * @return void
     */
    public function updating(Pickup $pickup): void
    {
        $this->defaultProperties($pickup);
    }

    /**
     * @param Pickup $pickup
     *
     * @return void
     */
    public function deleting(Pickup $pickup): void
    {
        $pickup->deleted_at = $pickup->deleted_at ?? Carbon::now();
    }

    /**
     * @param Pickup $pickup
     *
     * @return void
     */
    public function restoring(Pickup $pickup): void
    {
        $pickup->deleted_at = null;
    }

    /**
     * @param Pickup $pickup
     *
     * @return void
     */
    public function defaultProperties(Pickup $pickup): void
    {
        $pickup->note = $pickup->note;

        $pickup->bring_address = $pickup->bring_address;

        $pickup->bring_datetime_start = $pickup->bring_datetime_start;

        $pickup->bring_datetime_end = $pickup->bring_datetime_end;

        $pickup->staff_id = $pickup->staff_id;

        $pickup->driver_id = $pickup->driver_id;

        $pickup->customer_id = $pickup->customer_id;

        $pickup->created_at = $pickup->created_at ?? Carbon::now();

        $pickup->updated_at = $pickup->updated_at ?? Carbon::now();

        $pickup->deleted_at = $pickup->deleted_at ?? null;
    }


}
