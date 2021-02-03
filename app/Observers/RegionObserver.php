<?php

namespace App\Observers;

use App\Models\Region;

use Illuminate\Support\Carbon;


final class RegionObserver
{
    /**
     * @param Region $region
     *
     * @return void
     */
    public function creating(Region $region): void
    {
        $this->defaultProperties($region);
    }

    /**
     * @param Region $region
     *
     * @return void
     */
    public function updating(Region $region): void
    {
        $this->defaultProperties($region);
    }

    /**
     * @param Region $region
     *
     * @return void
     */
    public function deleting(Region $region): void
    {
        $region->deleted_at = $region->deleted_at ?? Carbon::now();

        $region->update();
    }

    /**
     * @param Region $region
     *
     * @return void
     */
    public function restoring(Region $region): void
    {
        $region->deleted_at = null;
    }

    /**
     * @param Region $region
     *
     * @return void
     */
    public function defaultProperties(Region $region): void
    {
        $region->created_at = $region->created_at ?? Carbon::now();

        $region->updated_at = $region->updated_at ?? Carbon::now();

        $region->deleted_at = $region->deleted_at ?? null;
    }
}
