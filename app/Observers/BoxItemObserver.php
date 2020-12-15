<?php

namespace App\Observers;

use App\Models\BoxItem;

use Illuminate\Support\Str;

use Illuminate\Support\Carbon;

class BoxItemObserver
{
    /**
     * @param BoxItem $boxItem
     *
     * @return void
     */
    public function creating(BoxItem $boxItem): void
    {
        $this->defaultProperties($boxItem);
    }

    /**
     * @param BoxItem $boxItem
     *
     * @return void
     */
    public function updating(BoxItem $boxItem): void
    {
        $this->defaultProperties($boxItem);
    }

    /**
     * @param BoxItem $boxItem
     *
     * @return void
     */
    public function deleting(BoxItem $boxItem): void
    {
        $boxItem->deleted_at = $boxItem->deleted_at ?? Carbon::now();
    }

    /**
     * @param BoxItem $boxItem
     *
     * @return void
     */
    public function restoring(BoxItem $boxItem): void
    {
        $boxItem->deleted_at = null;
    }

    /**
     * @param BoxItem $boxItem
     *
     * @return void
     */
    public function defaultProperties(BoxItem $boxItem): void
    {
        $boxItem->box_id = $boxItem->box_id;
        $boxItem->warehouse_item_id = $boxItem->warehouse_item_id;
        $boxItem->name = $boxItem->name;
        $boxItem->quantity = $boxItem->quantity;
        $boxItem->price = $boxItem->price;
        $boxItem->weight = $boxItem->weight;
        $boxItem->made_in = $boxItem->made_in;
        $boxItem->note = $boxItem->note;
        $boxItem->is_additional = $boxItem->is_additional ?? 0;
        $boxItem->created_at = $box->created_at ?? Carbon::now();
        $boxItem->updated_at = $box->updated_at ?? Carbon::now();
        $boxItem->deleted_at = $box->deleted_at ?? null;
    }
}
