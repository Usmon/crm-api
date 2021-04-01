<?php

namespace App\Observers;

use App\Models\Box;

use App\Models\Order;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

        $box->delivery_id = $box->delivery_id ?? null;

        $box->creator_id = $box->creator_id ?? auth()->user()->id;

        $box->additional_weight = $box->additional_weight ?? 0;

        $box->created_at = $box->created_at ?? Carbon::now();

        $box->updated_at = $box->updated_at ?? Carbon::now();

        $box->deleted_at = $box->deleted_at ?? null;
    }

    /**
     * @param Box $box
     *
     * @return void
     */
    public function created(Box $box): void
    {
//        $this->afterProperties($box->order_id);
    }

    /**
     * @param Box $box
     *
     * @return void
     */
    public function updated(Box $box): void
    {
//        $this->afterProperties($box->order_id);
    }

    /**
     * @param Box $box
     *
     * @return void
     */
    public function deleted(Box $box): void
    {
//        $this->afterProperties($box->order_id);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function afterProperties(int $id): void
    {
        // $order = Order::find($id);

        // $orderObserver = new OrderObserver();

        // $orderObserver->afterAddedOrUpdatedOrDeletedBoxProperties($order);
    }

    public function afterAddedOrUpdatedOrDeletedBoxItemProperties(int $id): void
    {
        $box = Box::find($id);

        $box->update([
            'weight' => $box->items()->sum('weight'),
        ]);
    }

}
