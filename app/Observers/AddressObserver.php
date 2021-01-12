<?php

namespace App\Observers;

use App\Models\Address;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class AddressObserver
{
    /**
     * @param Address $address
     *
     * @return void
     */
    public function creating(Address $address): void
    {
        $this->defaultProperties($address);
    }

    /**
     * @param Address $address
     *
     * @return void
     */
    public function updating(Address $address): void
    {
        $this->defaultProperties($address);
    }

    /**
     * @param Address $address
     *
     * @return void
     */
    public function deleting(Address $address): void
    {
        $address->deleted_by = $address->deleted_by ?? Auth::id();

        $address->deleted_at = $address->deleted_at ?? Carbon::now();

        $address->update();
    }

    /**
     * @param Address $address
     *
     * @return void
     */
    public function restoring(Address $address): void
    {
        $address->deleted_at = null;
    }

    /**
     * @param Address $address
     *
     * @return void
     */
    protected function defaultProperties(Address $address): void
    {
        $address->created_at = $address->created_at ?? Carbon::now();

        $address->updated_at = $address->updated_at ?? Carbon::now();

        $address->deleted_at = $address->deleted_at ?? null;
    }
}
