<?php

namespace App\Observers;

use App\Models\Delivery;

use Illuminate\Support\Carbon;

final class DeliveryObserver
{
    /**
     * @param Delivery $delivery
     *
     * @return void
     */
    public function creating(Delivery $delivery): void
    {
        $this->defaultProperties($delivery);
    }

    /**
     * @param Delivery $delivery
     *
     * @return void
     */
    public function updating(Delivery $delivery): void
    {
        $this->defaultProperties($delivery);
    }

    /**
     * @param Delivery $delivery
     *
     * @return void
     */
    public function deleting(Delivery $delivery): void
    {
        $delivery->deleted_at = $delivery->deleted_at ?? Carbon::now();
    }

    /**
     * @param Delivery $delivery
     *
     * @return void
     */
    public function restoring(Delivery $delivery): void
    {
        $delivery->deleted_at = null;
    }

    /**
     * @param Delivery $delivery
     *
     * @return void
     */
    public function defaultProperties(Delivery $delivery): void
    {
        $delivery->status = $delivery->status ?? 'pending';

        $delivery->created_at = $delivery->created_at ?? Carbon::now();

        $delivery->updated_at = $delivery->updated_at ?? Carbon::now();

        $delivery->deleted_at = $delivery->deleted_at ?? null;
    }
}
