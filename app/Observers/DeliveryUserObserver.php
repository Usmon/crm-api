<?php

namespace App\Observers;

use App\Models\DeliveryUser;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class DeliveryUserObserver
{
    /**
     * @param DeliveryUser $deliveryUser
     *
     * @return void
     */
    public function creating(DeliveryUser $deliveryUser): void
    {
        $this->defaultProperties($deliveryUser);
    }

    /**
     * @param DeliveryUser $deliveryUser
     *
     * @return void
     */
    public function updating(DeliveryUser $deliveryUser): void
    {
        $this->defaultProperties($deliveryUser);
    }

    /**
     * @param DeliveryUser $deliveryUser
     *
     * @return void
     */
    public function deleting(DeliveryUser $deliveryUser): void
    {
        $deliveryUser->deleted_by = $deliveryUser->deleted_by ?? Auth::id();

        $deliveryUser->deleted_at = $deliveryUser->deleted_at ?? Carbon::now();

        $deliveryUser->update();
    }

    /**
     * @param DeliveryUser $deliveryUser
     *
     * @return void
     */
    public function restoring(DeliveryUser $deliveryUser): void
    {
        $deliveryUser->deleted_at = null;
    }

    /**
     * @param DeliveryUser $deliveryUser
     *
     * @return void
     */
    protected function defaultProperties(DeliveryUser $deliveryUser): void
    {
        $deliveryUser->created_at = $deliveryUser->created_at ?? Carbon::now();

        $deliveryUser->updated_at = $deliveryUser->updated_at ?? Carbon::now();

        $deliveryUser->deleted_at = $deliveryUser->deleted_at ?? null;
    }
}
