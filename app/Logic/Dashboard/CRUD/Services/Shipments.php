<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Shipment;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Shipments as ShipmentsRequest;

final class Shipments
{
    /**
     * @param ShipmentsRequest $request
     *
     * @return array
     */
    public function getAllFilters(ShipmentsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'name' => $request->json('name'),

            'status' => $request->json('status'),

            'date' => $request->json('date'),
        ];
    }

    /**
     * @param ShipmentsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(ShipmentsRequest $request): array
    {
        return $request->only('search', 'date','name','status');
    }

    /**
     * @param ShipmentsRequest $request
     *
     * @return array
     */
    public function getAllSorts(ShipmentsRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param ShipmentsRequest $request
     *
     * @return array
     */
    public function getOnlySorts(ShipmentsRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getShipments(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Shipment $shipment) {
            return [
                'id' => $shipment->id,

                'name' => $shipment->name,

                'status' => $shipment->status,

                'created_at' => $shipment->created_at,

                'updated_at' => $shipment->updated_at,

                'total_boxes' => $shipment->total_boxes,

                'total_weight_boxes' => $shipment->total_weight_boxes,

                'total_price_orders' => $shipment->total_price_orders,
            ];
        });

        return $paginator;
    }

    /**
     * @param Shipment $shipment
     *
     * @return array
     */
    public function showShipment(Shipment $shipment): array
    {
        return [
            'id' => $shipment->id,

            'shipment_name' => $shipment->name,

            'total_customers' => 'TOTAL CUSTOMERS',

            'total_orders' => $shipment->total_orders,

            'total_boxes' => $shipment->total_boxes,

            'total_price' => $shipment->total_price_orders,

            'total_weight' => $shipment->total_weight_boxes,

            'created_at' => $shipment->created_at,

            'status' => [
                'id' => $shipment->status->id,

                'name' => $shipment->status->value,

                'color' => [
                    'bg' => $shipment->status->parameters['color']['bg'],

                    'text' => $shipment->status->parameters['color']['text'],
                ],
            ],

            'creator' => [
                'id' => $shipment->creator->id,

                'name' => $shipment->creator->profile['first_name'] . ' ' . $shipment->creator->profile['last_name'] . ' ' . $shipment->creator->profile['middle_name'],

                'image' => $shipment->creator->profile['photo'],

                'phones' => $shipment->creatorPhones(),
            ],
        ];
    }

    /**
     * @param ShipmentsRequest $request
     *
     * @return array
     */
    public function storeCredentials(ShipmentsRequest $request): array
    {
        return [
            'name' => $request->json('name'),

            'status' => $request->json('status'),
        ];
    }

    /**
     * @param ShipmentsRequest $request
     *
     * @return array
     */
    public function updateCredentials(ShipmentsRequest $request): array
    {
        $credentials = [
            'name' => $request->json('name'),

            'status' => $request->json('status'),
        ];

        return $credentials;
    }
}
