<?php

namespace App\Observers;

use App\Models\BoxItem;

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
     */
    public function created(BoxItem $boxItem): void
    {
        (new BoxObserver())->afterAddedOrUpdatedOrDeletedBoxItemProperties($boxItem->box_id);
    }

    /**
     * @param BoxItem $boxItem
     */
    public function updated(BoxItem $boxItem): void
    {
        (new BoxObserver())->afterAddedOrUpdatedOrDeletedBoxItemProperties($boxItem->box_id);
    }

    /**
     * @param BoxItem $boxItem
     */
    public function deleted(BoxItem $boxItem): void
    {
        (new BoxObserver())->afterAddedOrUpdatedOrDeletedBoxItemProperties($boxItem->box_id);
    }

    /**
     * @param BoxItem $boxItem
     *
     * @return void
     */
    public function defaultProperties(BoxItem $boxItem): void
    {
        $boxItem->is_additional = $boxItem->is_additional ?? 0;

        $boxItem->created_at = $box->created_at ?? Carbon::now();

        $boxItem->updated_at = $box->updated_at ?? Carbon::now();

        $boxItem->deleted_at = $box->deleted_at ?? null;
    }
}
