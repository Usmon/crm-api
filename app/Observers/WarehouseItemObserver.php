<?php

namespace App\Observers;

use App\Models\WarehouseItem;

use Illuminate\Support\Carbon;

final class WarehouseItemObserver
{
    /**
     * @param WarehouseItem $warehouseItem
     */
    public function creating(WarehouseItem $warehouseItem): void
    {
        $this->defaultProperties($warehouseItem);
    }

    /**
     * @param WarehouseItem $warehouseItem
     */
    public function updating(WarehouseItem $warehouseItem): void
    {
        $this->defaultProperties($warehouseItem);
    }

    /**
     * @param WarehouseItem $warehouseItem
     */
    public function deleting(WarehouseItem $warehouseItem): void
    {
        $warehouseItem->deleted_at = $warehouseItem->deleted_at ?? Carbon::now();
    }

    /**
     * @param WarehouseItem $warehouseItem
     */
    public function restoring(WarehouseItem $warehouseItem): void
    {
        $warehouseItem->deleted_at = null;
    }

    /**
     * @param WarehouseItem $warehouseItem
     */
    protected function defaultProperties(WarehouseItem $warehouseItem): void
    {
        $warehouseItem->created_at = $warehouseItem->created_at ?? Carbon::now();

        $warehouseItem->updated_at = $warehouseItem->updated_at ?? Carbon::now();

        $warehouseItem->deleted_at = $warehouseItem->deleted_at ?? null;
    }
}
