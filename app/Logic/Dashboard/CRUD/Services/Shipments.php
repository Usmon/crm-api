<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Box;
use App\Models\Order;
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

                'total_customers' => $shipment->orders->count(),

                'total_orders' => $shipment->orders()->count(),

                'total_boxes' => $shipment->boxes()->count(),

                'total_price' => $shipment->boxes->map(function (Box $box) {
                    return $box->items()->sum('price');
                })->sum(),

                'total_weight' => $shipment->boxes->map(function (Box $box) {
                    return $box->items()->sum('weight');
                })->sum(),

                'created_at' => $shipment->created_at,

                'status' => $shipment->status->for_color,

                'creator' => $shipment->creator->short_info,
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

            'total_boxes' => $shipment->boxes()->count(),

            'name' => $shipment->name,

            'total_products' => $shipment->boxes->map(function (Box $box) {
                return $box->items()->count();
            })->sum(),

            'total_customers' => 'TOTAL CUSTOMERS',

            'total_weight' => $shipment->boxes->map(function (Box $box) {
                return $box->items()->sum('weight');
            })->sum(),

            'price_total' => $shipment->boxes->map(function (Box $box) {
                return $box->items()->sum('price');
            })->sum(),

            'payment_type' => 'PAYMENT TYPE' ,

            'created_at' => $shipment->created_at,

            'updated_at' => $shipment->updated_at,

            'creator' => [
                'id' => $shipment->creator->id,

                'name' => $shipment->creatorName(),
            ],

            'status' => [
                'id' => $shipment->status->id,

                'name' => $shipment->status->value,

                'color' => [
                    'bg' => $shipment->statusColorBg(),

                    'text' => $shipment->statusColorText(),
                ],
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

//            'boxes' => $request->json('boxes'),
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
            'status_id' => $request->json('status_id'),

            'name' => $request->json('name'),

//            'boxes' => $request->json('boxes'),
        ];

        return $credentials;
    }
}
