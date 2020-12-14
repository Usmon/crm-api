<?php

namespace App\Observers;

use App\Models\OrderUser;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class OrderUserObserver
{
    /**
     * @param OrderUser $orderUser
     *
     * @return void
     */
    public function creating(OrderUser $orderUser): void
    {
        $this->defaultProperties($orderUser);
    }

    /**
     * @param OrderUser $orderUser
     *
     * @return void
     */
    public function updating(OrderUser $orderUser): void
    {
        $this->defaultProperties($orderUser);
    }

    /**
     * @param OrderUser $orderUser
     *
     * @return void
     */
    public function deleting(OrderUser $orderUser): void
    {
        $orderUser->deleted_by = $orderUser->deleted_by ?? Auth::id();

        $orderUser->deleted_at = $orderUser->deleted_at ?? Carbon::now();

        $orderUser->update();
    }

    /**
     * @param OrderUser $orderUser
     *
     * @return void
     */
    public function restoring(OrderUser $orderUser): void
    {

        $orderUser->deleted_at = null;
    }

    /**
     * @param OrderUser $orderUser
     *
     * @return void
     */
    protected function defaultProperties(OrderUser $orderUser): void
    {
        $orderUser->created_at = $orderUser->created_at ?? Carbon::now();

        $orderUser->updated_at = $orderUser->updated_at ?? Carbon::now();

        $orderUser->deleted_at = $orderUser->deleted_at ?? null;
    }
}
