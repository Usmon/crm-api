<?php

namespace App\Observers;

use App\Models\Box;

use Illuminate\Support\Str;

use Illuminate\Support\Carbon;

class BoxObserver
{
    /**
     * @param Box $box
     *
     * @return void
     */
    public function creating(Box $box): void
    {
        $this->defaultProperties($box);
    }

    /**
     * @param Box $box
     *
     * @return void
     */
    public function updating(Box $box): void
    {
        $this->defaultProperties($box);
    }

    /**
     * @param Box $box
     *
     * @return void
     */
    public function deleting(Box $box): void
    {
        $box->deleted_at = $box->deleted_at ?? Carbon::now();
    }

    /**
     * @param Box $box
     *
     * @return void
     */
    public function restoring(Box $box): void
    {
        $box->deleted_at = null;
    }

    /**
     * @param Box $box
     *
     * @return void
     */
    public function defaultProperties(Box $box): void
    {
        $box->order_id = $box->order_id;
        $box->customer_id = $box->customer_id;
        $box->sender_id = $box->sender_id;
        $box->recipient_id = $box->recipient_id;
        $box->weight = $box->weight;
        $box->additional_weight = $box->additional_weight;
        $box->status = $box->status ?? 'pending';
        $box->box_image = $box->box_image;
        $box->created_at = $box->created_at ?? Carbon::now();
        $box->updated_at = $box->updated_at ?? Carbon::now();
        $box->deleted_at = $box->deleted_at ?? null;
    }


}
