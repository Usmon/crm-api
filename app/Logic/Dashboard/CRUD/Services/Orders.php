<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Logic\Dashboard\CRUD\Requests\Orders as OrdersRequest;

use App\Models\Box;

use App\Models\Order;

use App\Models\OrderHistory;

use Illuminate\Contracts\Pagination\Paginator;

/**
 * Class Orders
 *
 * @package App\Logic\Dashboard\CRUD\Services
 */
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

            'status_id' => $request->json('status_id'),

            'price' => $request->json('price'),

            'payed_price' => $request->json('payed_price'),

            'payment_status_id' => $request->json('payment_status_id'),

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
        return $request->only('search',
            'date',

            'staff_id',

            'customer_id',

            'fedex_order_id',

            'status_id',

            'payment_status_id',

            'partner_id',

            'pickup_id',

            'staff_id',

            'price',

            'payed_price',

            'staff',

            'customer',

            'pickup',

            'shipment',

            'total_boxes',

            'total_weight_boxes',

            'total_delivered_boxes');
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

                'total_boxes' => $order->total_boxes,

                'partner' => $order->staff->partner->name,

                'creator' => $order->staff->short_info,

                'customer' => $order->sender->customer->user->short_info,

                'status' => $order->status->for_color,

                'payment_status' => $order->payment_status->for_color,

                'created_at' => $order->created_at,

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

            'total_boxes' => $order->total_boxes,

            'total_products' => $order->total_products,

            'price_debt' => $order->price,

            'payed_price' => $order->payed_price,

            'price_pickup' => $order->price_pickup,

            'price_delivery' => $order->price_delivery,

            'price_warehouse' => $order->price_warehouse,

            'price_fedex' => $order->price_fedex,

            'price_insurance' => $order->price_insurance,

            'price_total' => $order->price_total,

            'price_payed' => $order->payed_price,

            'price_discount' => $order->price_discount,

            'weight_rate' => $order->weight_rate,

            'total_weight' => $order->total_weight_boxes,

            'total_additional_weight' => $order->total_additional_weight,

            'payment_type' => $order->paymentType->name,

            'status' => $order->status->for_color,

            'payment_status' => $order->payment_status->for_color,

            'sender' => $order->sender->customer->user->short_info,

            'recipient' => $order->recipient->customer->user->short_info,

            'creator' => [
                'id' => $order->staff_id,

                'name' => $order->staff->full_name
            ],

            'boxes' => $order->boxes->transform(function(Box $box) {
                return [
                    'id' => $box->id,

                    'total_products' => $box->total_products,

                    'total_weight' => $box->weight,

                    'total_price' => $box->items->sum('price'),

                    'note' => $box->note,

                    'created_at' =>$box->created_at,

                    'creator' => [
                        'id' => $box->order->staff_id,

                        'name' => $box->order->staff->full_name
                    ],

                    'status' => $box->status->for_color
                ];
            }),

            'history' => $order->histories->transform(function(OrderHistory $history) {
                return [
                    'id' => $history->id,

                    'seq' => $history->seq,

                    'creator' => [
                        'id' => $history->creator_id,

                        'name' => $history->creator->full_name,
                    ],

                    'created_at' => $history->created_at
                ];
            }),

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
            'sender_id' => $request->json('sender_id'),

            'recipient_id' => $request->json('recipient_id'),

            'status_id' => $request->json('status_id'),

            'payment_status_id' => $request->json('payment_status_id'),

            'type' => $request->json('type'),

            'boxes' => $request->json('boxes'),

            'price' => $request->json('price'),

        ];
    }

    /**
     * @param OrdersRequest $request
     *
     * @return array
     */
    public function updateCredentials(OrdersRequest $request): array
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
