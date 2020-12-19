<?php

namespace App\Observers;

use App\Models\FedexOrderItem;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class FedexOrderItemObserver
{
    /**
     * @param FedexOrderItem $fedexOrderItem
     *
     * @return void
     */
    public function creating(FedexOrderItem $fedexOrderItem): void
    {
        $this->defaultProperties($fedexOrderItem);
    }

    /**
     * @param FedexOrderItem $fedexOrderItem
     *
     * @return void
     */
    public function updating(FedexOrderItem $fedexOrderItem): void
    {
        $this->defaultProperties($fedexOrderItem);
    }

    /**
     * @param FedexOrderItem $fedexOrderItem
     *
     * @return void
     */
    public function deleting(FedexOrderItem $fedexOrderItem): void
    {
        $fedexOrderItem->deleted_at = $fedexOrderItem->deleted_at ?? Carbon::now();

        $fedexOrderItem->deleted_by = $fedexOrderItem->deleted_by ?? Auth::id();

        $fedexOrderItem->update();
    }

    /**
     * @param FedexOrderItem $fedexOrderItem
     *
     * @return void
     */
    public function restoring(FedexOrderItem $fedexOrderItem): void
    {

        $fedexOrderItem->deleted_at = null;
    }

    /**
     * @param FedexOrderItem $fedexOrderItem
     *
     * @return void
     */
    protected function defaultProperties(FedexOrderItem $fedexOrderItem): void
    {
        $fedexOrderItem->created_at = $fedexOrderItem->created_at ?? Carbon::now();

        $fedexOrderItem->updated_at = $fedexOrderItem->updated_at ?? Carbon::now();

        $fedexOrderItem->deleted_at = $fedexOrderItem->deleted_at ?? null;
    }
}
