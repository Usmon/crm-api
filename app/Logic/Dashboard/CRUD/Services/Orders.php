<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Logic\Dashboard\CRUD\Requests\Orders as OrdersRequest;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

final class Orders
{
    /**
     * @param OrdersRequest $request
     *
     * @return array
     */
    public function getAllFilters(OrdersRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'staff_id' => $request->json('staff_id'),

            'customer_id' => $request->json('customer_id'),

            'fedex_order_id' => $request->json('fedex_order_id'),

            'pickup_id' => $request->json('pickup_id'),

            'shipment_id' => $request->json('shipment_id'),

            'status' => $request->json('status'),

            'price' => $request->json('price'),

            'payed_price' => $request->json('payed_price'),

            'payment_status' => $request->json('payment_status'),
        ];
    }

    /**
     * @param OrdersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(OrdersRequest $request): array
    {
        return $request->only('search', 'date', 'staff_id', 'customer_id', 'fedex_order_id',
            'pickup_id', 'staff_id', 'price','payed_price','status','payment_status');
    }

    /**
     * @param Collection $collection
     *
     * @return Collection
     */
    public function getOrders(Collection $collection): Collection
    {
        return $collection->transform(function (Order $order) {
            return [
                'id' => $order->id,

                'staff_id' => $order->staff_id,

                'customer_id' => $order->customer_id,

                'fedex_order_id' => $order->fedex_order_id,

                'pickup_id' => $order->pickup_id,

                'shipment_id' => $order->shipment_id,

                'price' => $order->price,

                'payed_price' => $order->payed_price,

                'status' => $order->status,

                'payment_status' => $order->payment_status,

                'created_at' => $order->created_at,

                'updated_at' => $order->updated_at,
            ];
        });
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    public function showOrder(Order $order): array
    {
        return [
            'id' => $order->id,

            'staff_id' => $order->staff_id,

            'customer_id' => $order->customer_id,

            'fedex_order_id' => $order->fedex_order_id,

            'pickup_id' => $order->pickup_id,

            'shipment_id' => $order->shipment_id,

            'price' => $order->price,

            'payed_price' => $order->payed_price,

            'status' => $order->status,

            'payment_status' => $order->payment_status,

            'created_at' => $order->created_at,

            'updated_at' => $order->updated_at,
        ];
    }

    /**
     * @param OrdersRequest $request
     *
     * @return array
     */
    public function storeCredentials(OrdersRequest $request): array
    {
        return [
            'staff_id' => $request->json('staff_id'),

            'customer_id' => $request->json('customer_id'),

            'fedex_order_id' => $request->json('fedex_order_id'),

            'pickup_id' => $request->json('pickup_id'),

            'shipment_id' => $request->json('shipment_id'),

            'price' => $request->json('price'),

            'payed_price' => $request->json('payed_price'),

            'status' => $request->json('status'),

            'payment_status' => $request->json('payment_status')
        ];
    }

    /**
     * @param OrdersRequest $request
     *
     * @return array
     */
    public function updateCredentials(OrdersRequest $request): array
    {
        $credentials = [
            'staff_id' => $request->json('staff_id'),

            'customer_id' => $request->json('customer_id'),

            'fedex_order_id' => $request->json('fedex_order_id'),

            'pickup_id' => $request->json('pickup_id'),

            'shipment_id' => $request->json('shipment_id'),

            'price' => $request->json('price'),

            'payed_price' => $request->json('payed_price'),

            'status' => $request->json('status'),

            'payment_status' => $request->json('payment_status')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteOrder($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
