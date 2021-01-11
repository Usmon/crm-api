<?php

namespace App\Observers;

use App\Models\Phone;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class PhoneObserver
{
    /**
     * @param Phone $phone
     *
     * @return void
     */
    public function creating(Phone $phone): void
    {
        $this->defaultProperties($phone);
    }

    /**
     * @param Phone $phone
     *
     * @return void
     */
    public function updating(Phone $phone): void
    {
        $this->defaultProperties($phone);
    }

    /**
     * @param Phone $phone
     *
     * @return void
     */
    public function deleting(Phone $phone): void
    {
        $phone->deleted_by = $phone->deleted_by ?? Auth::id();

        $phone->deleted_at = $phone->deleted_at ?? Carbon::now();

        $phone->update();
    }

    /**
     * @param Phone $phone
     *
     * @return void
     */
    public function restoring(Phone $phone): void
    {
        $phone->deleted_at = null;
    }

    /**
     * @param Phone $phone
     *
     * @return void
     */
    protected function defaultProperties(Phone $phone): void
    {
        $phone->created_at = $phone->created_at ?? Carbon::now();

        $phone->updated_at = $phone->updated_at ?? Carbon::now();

        $phone->deleted_at = $phone->deleted_at ?? null;
    }
}
