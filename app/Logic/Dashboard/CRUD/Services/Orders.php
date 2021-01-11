<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Logic\Dashboard\CRUD\Requests\Orders as OrdersRequest;

use App\Models\Order;

use Illuminate\Contracts\Pagination\Paginator;

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

            'staff' => $request->json('staff'),

            'customer' => $request->json('customer'),

            'pickup' => $request->json('pickup'),

            'shipment' => $request->json('shipment'),

            'total_boxes' => $request->json('total_boxes'),

            'total_weight_boxes' => $request->json('total_weight_boxes'),

            'total_delivered_boxes' => $request->json('total_delivered_boxes'),
        ];
    }

    /**
     * @param OrdersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(OrdersRequest $request): array
    {
        return $request->only('search', 'date', 'staff_id', 'customer_id', 'fedex_order_id', 'pickup_id',
            'staff_id', 'price','payed_price','status','payment_status', 'staff', 'customer', 'pickup', 'shipment',
        'total_boxes', 'total_weight_boxes', 'total_delivered_boxes');
    }

    /**
     * @param OrdersRequest $request
     *
     * @return array
     */
    public function getAllSorts(OrdersRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param OrdersRequest $request
     *
     * @return array
     */
    public function getOnlySorts(OrdersRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getOrders(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Order $order) {
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

                'staff' => $order->staff,

                'customer' => $order->customer,

                'fedex_order' => $order->fedex_order,

                'pickup' => $order->pickup,

                'shipment' => $order->shipment,

                'boxes' => $order->boxes,

                'total_boxes' => $order->total_boxes,

                'total_weight_boxes' => $order->total_weight_boxes,

                'total_delivered_boxes' => $order->total_delivered_boxes,
            ];
        });
        return $paginator;
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

            'staff' => $order->staff,

            'customer' => $order->customer,

            'fedex_order' => $order->fedex_order,

            'pickup' => $order->pickup,

            'shipment' => $order->shipment,

            'boxes' => $order->boxes,

            'total_boxes' => $order->total_boxes,

            'total_weight_boxes' => $order->total_weight_boxes,

            'total_delivered_boxes' => $order->total_delivered_boxes,
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
