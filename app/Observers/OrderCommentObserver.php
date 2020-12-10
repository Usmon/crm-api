<?php

namespace App\Observers;

use App\Models\OrderComment;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class OrderCommentObserver
{
    /**
     * @param OrderComment $orderComment
     *
     * @return void
     */
    public function creating(OrderComment $orderComment): void
    {
        $this->defaultProperties($orderComment);
    }

    /**
     * @param OrderComment $orderComment
     *
     * @return void
     */
    public function updating(OrderComment $orderComment): void
    {
        $this->defaultProperties($orderComment);
    }

    /**
     * @param OrderComment $orderComment
     *
     * @return void
     */
    public function deleting(OrderComment $orderComment): void
    {
        $orderComment->deleted_by = $orderComment->deleted_by ?? Auth::id();

        $orderComment->deleted_at = $orderComment->deleted_at ?? Carbon::now();

        $orderComment->update();
    }

    /**
     * @param OrderComment $orderComment
     *
     * @return void
     */
    public function restoring(OrderComment $orderComment): void
    {
        $orderComment->deleted_at = null;
    }

    /**
     * @param OrderComment $orderComment
     *
     * @return void
     */
    protected function defaultProperties(OrderComment $orderComment): void
    {
        $orderComment->created_at = $orderComment->created_at ?? Carbon::now();

        $orderComment->updated_at = $orderComment->updated_at ?? Carbon::now();

        $orderComment->owner_id = $orderComment->owner_id ?? Auth::id();

        $orderComment->deleted_at = $orderComment->deleted_at ?? null;
    }
}
