<?php

namespace App\Observers;

use App\Models\Order;

use App\Models\Shipment;

use Illuminate\Support\Carbon;

final class OrderObserver
{
    /**
     * @param Order $order
     *
     * @return void
     */
    public function creating(Order $order): void
    {
        $this->defaultProperties($order);
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function updating(Order $order): void
    {
        $this->defaultProperties($order);

        $order->histories()->create([
            'model_id' => $order->id,

            'status_id' => $order->status_id,

            'seq' => 0,

            'model' => Order::class,

            'creator_id' => auth()->user()->id
        ]);
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function deleting(Order $order): void
    {
        $order->deleted_at = $order->deleted_at ?? Carbon::now();
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function restoring(Order $order): void
    {
        $order->deleted_at = null;
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    protected function defaultProperties(Order $order): void
    {
        $order->payed_price = $order->payed_price ?? 0;

        $order->staff_id = $order->staff_id ?? auth()->user()->id;

        $order->created_at = $order->created_at ?? Carbon::now();

        $order->updated_at = $order->updated_at ?? Carbon::now();

        $order->deleted_at = $order->deleted_at ?? null;
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function afterAddedOrUpdatedOrDeletedBoxProperties(Order $order): void
    {
        $order->total_boxes = $order->totalBoxes;

        $order->total_weight_boxes = $order->totalWeightBoxes;

        $order->total_delivered_boxes = $order->totalDeliveredBoxes;

        $order->update();

        $shipment = Shipment::find($order->shipment_id);

        $shipmentObserver = new ShipmentObserver();

        $shipmentObserver->afterAddedOrUpdatedOrDeletedBoxProperties($shipment);
    }
}
