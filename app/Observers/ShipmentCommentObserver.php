<?php

namespace App\Observers;

use Illuminate\Support\Carbon;

use App\Models\ShipmentComment;

use Illuminate\Support\Facades\Auth;

final class ShipmentCommentObserver
{
    /**
     * @param ShipmentComment $shipmentComment
     */
    public function creating(ShipmentComment $shipmentComment): void
    {
        $this->defaultProperties($shipmentComment);
    }

    /**
     * @param ShipmentComment $shipmentComment
     */
    public function updating(ShipmentComment $shipmentComment): void
    {
        $this->defaultProperties($shipmentComment);
    }

    /**
     * @param ShipmentComment $shipmentComment
     */
    public function deleting(ShipmentComment $shipmentComment): void
    {
        $shipmentComment->deleted_by = $shipmentComment->deleted_by ?? Auth::id();

        $shipmentComment->deleted_at = $shipmentComment->deleted_at ?? Carbon::now();

        $shipmentComment->update();
    }

    /**
     * @param ShipmentComment $shipmentComment
     */
    public function restoring(ShipmentComment $shipmentComment): void
    {
        $shipmentComment->deleted_at = null;
    }

    /**
     * @param ShipmentComment $shipmentComment
     */
    protected function defaultProperties(ShipmentComment $shipmentComment): void
    {
        $shipmentComment->created_at = $shipmentComment->created_at ?? Carbon::now();

        $shipmentComment->updated_at = $shipmentComment->updated_at ?? Carbon::now();

        $shipmentComment->owner_id = $shipmentComment->owner_id ?? Auth::id();

        $shipmentComment->deleted_at = $shipmentComment->deleted_at ?? null;

        $shipmentComment->deleted_by = $shipmentComment->deleted_by ?? null;
    }
}
