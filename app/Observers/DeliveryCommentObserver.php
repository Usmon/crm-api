<?php

namespace App\Observers;

use App\Models\DeliveryComment;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class DeliveryCommentObserver
{
    /**
     * @param DeliveryComment $deliveryComment
     *
     * @return void
     */
    public function creating(DeliveryComment $deliveryComment): void
    {
        $this->defaultProperties($deliveryComment);
    }

    /**
     * @param DeliveryComment $deliveryComment
     *
     * @return void
     */
    public function updating(DeliveryComment $deliveryComment): void
    {
        $this->defaultProperties($deliveryComment);
    }

    /**
     * @param DeliveryComment $deliveryComment
     *
     * @return void
     */
    public function deleting(DeliveryComment $deliveryComment): void
    {
        $deliveryComment->deleted_by = $deliveryComment->deleted_by ?? Auth::id();

        $deliveryComment->deleted_at = $deliveryComment->deleted_at ?? Carbon::now();

        $deliveryComment->update();
    }

    /**
     * @param DeliveryComment $deliveryComment
     *
     * @return void
     */
    public function restoring(DeliveryComment $deliveryComment): void
    {
        $deliveryComment->deleted_at = null;
    }

    /**
     * @param DeliveryComment $deliveryComment
     *
     * @return void
     */
    protected function defaultProperties(DeliveryComment $deliveryComment): void
    {
        $deliveryComment->created_at = $deliveryComment->created_at ?? Carbon::now();

        $deliveryComment->updated_at = $deliveryComment->updated_at ?? Carbon::now();

        $deliveryComment->deleted_at = $deliveryComment->deleted_at ?? null;

        $deliveryComment->owner_id = $deliveryComment->owner_id ?? Auth::id();
    }
}
