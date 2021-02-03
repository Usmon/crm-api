<?php

namespace App\Observers;

use App\Models\City;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final  class CityObserver
{
    /**
     * @param City $city
     *
     * @return void
     */
    public function creating(City $city): void
    {
        $this->defaultProperties($city);
    }

    /**
     * @param City $city
     *
     * @return void
     */
    public function updating(City $city): void
    {
        $this->defaultProperties($city);
    }

    /**
     * @param City $city
     *
     * @return void
     */
    public function deleting(City $city): void
    {
        $city->deleted_by = $city->deleted_by ?? Auth::id();

        $city->deleted_at = $city->deleted_at ?? Carbon::now();

        $city->update();
    }

    /**
     * @param City $city
     *
     * @return void
     */
    public function restoring(City $city): void
    {
        $city->deleted_at = null;
    }

    /**
     * @param City $city
     *
     * @return void
     */
    protected function defaultProperties(City $city): void
    {
        $city->created_at = $city->created_at ?? Carbon::now();

        $city->updated_at = $city->updated_at ?? Carbon::now();

        $city->deleted_at = $city->deleted_at ?? null;
    }
}
