<?php

namespace App\Observers;

use App\Models\Tracking;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class TrackingObserver
{
    /**
     * @param Tracking $tracking
     *
     * @return void
     */
    public function creating(Tracking $tracking): void
    {
        $this->defaultProperties($tracking);
    }

    /**
     * @param Tracking $tracking
     *
     * @return void
     */
    public function updating(Tracking $tracking): void
    {
        $this->defaultProperties($tracking);
    }

    /**
     * @param Tracking $tracking
     *
     * @return void
     */
    public function deleting(Tracking $tracking): void
    {
        $tracking->deleted_by = Auth::id();

        $tracking->deleted_at = $tracking->deleted_at ?? Carbon::now();

        $tracking->update();
    }

    /**
     * @param Tracking $tracking
     *
     * @return void
     */
    public function restoring(Tracking $tracking): void
    {

        $tracking->deleted_at = null;
    }

    /**
     * @param Tracking $tracking
     *
     * @return void
     */
    protected function defaultProperties(Tracking $tracking): void
    {
        $tracking->created_at = $tracking->created_at ?? Carbon::now();

        $tracking->updated_at = $tracking->updated_at ?? Carbon::now();

        $tracking->deleted_at = $tracking->deleted_at ?? null;

        $tracking->deleted_by = $tracking->deleted_by ?? null;
    }
}
