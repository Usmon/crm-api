<?php

namespace App\Observers;

use App\Models\FedexOrder;

use Illuminate\Support\Carbon;

final class FedexOrderObserver
{
    /**
     * @param FedexOrder $fedex_order
     *
     * @return void
     */
    public function creating(FedexOrder $fedex_order): void
    {
        $this->defaultProperties($fedex_order);
    }

    /**
     * @param FedexOrder $fedex_order
     *
     * @return void
     */
    public function updating(FedexOrder $fedex_order): void
    {
        $this->defaultProperties($fedex_order);
    }

    /**
     * @param FedexOrder $fedex_order
     *
     * @return void
     */
    public function deleting(FedexOrder $fedex_order): void
    {
        $fedex_order->deleted_at = $fedex_order->deleted_at ?? Carbon::now();
    }

    /**
     * @param FedexOrder $fedex_order
     *
     * @return void
     */
    public function restoring(FedexOrder $fedex_order): void
    {

        $fedex_order->deleted_at = null;
    }

    /**
     * @param FedexOrder $fedex_order
     *
     * @return void
     */
    protected function defaultProperties(FedexOrder $fedex_order): void
    {
        $fedex_order->created_at = $fedex_order->created_at ?? Carbon::now();

        $fedex_order->service_type = $fedex_order->service_type ? $fedex_order->service_type : 'ground';

        $fedex_order->status = $fedex_order->status ? $fedex_order->status : 'pending';

        $fedex_order->updated_at = $fedex_order->updated_at ?? Carbon::now();

        $fedex_order->deleted_at = $fedex_order->deleted_at ?? null;
    }
}
