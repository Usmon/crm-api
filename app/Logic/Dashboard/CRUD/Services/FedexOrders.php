<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\FedexOrder;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\FedexOrders as FedexOrdersRequest;

final class FedexOrders
{
    /**
     * @param FedexOrdersRequest $request
     * @return array
     */
    public function getAllFilters(FedexOrdersRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'service_type' => $request->json('service_type'),

            'transit_time' => $request->json('transit_time'),

            'status' => $request->json('status'),

            'staff_id' => $request->json('staff_id'),

            'customer_id' => $request->json('customer_id'),
        ];
    }

    /**
     * @param FedexOrdersRequest $request
     * @return array
     */
    public function getOnlyFilters(FedexOrdersRequest $request): array
    {
        return $request->only('search', 'date', 'service_type', 'transit_time', 'status', 'customer_id', 'staff_id');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getFedexOrders(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (FedexOrder $fedexOrder) {
            return [
                'id' => $fedexOrder->id,

                'price' => $fedexOrder->price,

                'discount_price' => $fedexOrder->discount_price,

                'service_type' => $fedexOrder->service_type,

                'tracking_number' => $fedexOrder->tracking_number,

                'transit_time' => $fedexOrder->transit_time,

                'status' => $fedexOrder->status,

                'staff_id' => $fedexOrder->staff_id,

                'arrived_at' => $fedexOrder->arrived_at,

                'customer_id' => $fedexOrder->customer_id,

                'created_at' => $fedexOrder->created_at,

                'updated_at' => $fedexOrder->updated_at,

                'customer' => $fedexOrder->customer,

                'staff' => $fedexOrder->staff,
            ];
        });
        return $paginator;
    }

    /**
     * @param FedexOrder $fedexOrder
     * @return array
     */
    public function showFedexOrder(FedexOrder $fedexOrder): array
    {
        return [
            'id' => $fedexOrder->id,

            'price' => $fedexOrder->price,

            'discount_price' => $fedexOrder->discount_price,

            'service_type' => $fedexOrder->service_type,

            'tracking_number' => $fedexOrder->tracking_number,

            'transit_time' => $fedexOrder->transit_time,

            'status' => $fedexOrder->status,

            'staff_id' => $fedexOrder->staff_id,

            'arrived_at' => $fedexOrder->arrived_at,

            'customer_id' => $fedexOrder->customer_id,

            'created_at' => $fedexOrder->created_at,

            'updated_at' => $fedexOrder->updated_at,

            'customer' => $fedexOrder->customer,

            'staff' => $fedexOrder->staff,

            'items' => $fedexOrder->items
        ];
    }

    /**
     * @param FedexOrdersRequest $request
     * @return array
     */
    public function storeCredentials(FedexOrdersRequest $request): array
    {
        return [
            'price' => $request->json('price'),

            'discount_price' => $request->json('discount_price'),

            'service_type' => $request->json('service_type'),

            'tracking_number' => $request->json('tracking_number'),

            'transit_time' => $request->json('transit_time'),

            'status' => $request->json('status'),

            'staff_id' => $request->json('staff_id'),

            'arrived_at' => $request->json('arrived_at'),

            'customer_id' => $request->json('customer_id')
        ];
    }

    /**
     * @param FedexOrdersRequest $request
     * @return array
     */
    public function updateCredentials(FedexOrdersRequest $request): array
    {
        $credentials = [
            'price' => $request->json('price'),

            'discount_price' => $request->json('discount_price'),

            'service_type' => $request->json('service_type'),

            'tracking_number' => $request->json('tracking_number'),

            'transit_time' => $request->json('transit_time'),

            'status' => $request->json('status'),

            'staff_id' => $request->json('staff_id'),

            'arrived_at' => $request->json('arrived_at'),

            'customer_id' => $request->json('customer_id')
        ];

        return $credentials;
    }
}
