<?php

namespace App\Observers;

use App\Models\Pickup;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

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

        $pickup->deleted_by = $pickup->deleted_by ?? Auth::id();

        $pickup->update();
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
        $pickup->creator_id = $pickup->creator_id ?? Auth::id();

        $pickup->created_at = $pickup->created_at ?? Carbon::now();

        $pickup->updated_at = $pickup->updated_at ?? Carbon::now();

        $pickup->deleted_at = $pickup->deleted_at ?? null;

        $pickup->deleted_by = $pickup->deleted_by ?? null;
    }
}
