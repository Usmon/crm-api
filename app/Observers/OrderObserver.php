<?php

namespace App\Observers;

use App\Models\Order;

use Illuminate\Support\Carbon;

final class OrderObserver
{
    /**
     * @param Order $order
     *
     * @return void
     */
    public function creating(Order $order): void
    {
        $this->defaultProperties($order);
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function updating(Order $order): void
    {
        $this->defaultProperties($order);
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function deleting(Order $order): void
    {
        $order->deleted_at = $order->deleted_at ?? Carbon::now();
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function restoring(Order $order): void
    {

        $order->deleted_at = null;
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    protected function defaultProperties(Order $order): void
    {
        $order->created_at = $order->created_at ?? Carbon::now();

        $order->updated_at = $order->updated_at ?? Carbon::now();

        $order->deleted_at = $order->deleted_at ?? null;
    }
}
