<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Shipment;

use App\Logic\Dashboard\CRUD\Requests\Shipments as ShipmentsRequest;

use Illuminate\Database\Eloquent\Collection;

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
     * @param Collection $collection
     *
     * @return Collection
     */
    public function getShipments(Collection $collection): Collection
    {
        return $collection->transform(function (Shipment $shipment) {
            return [
                'id' => $shipment->id,

                'name' => $shipment->name,

                'status' => $shipment->status,

                'created_at' => $shipment->created_at,

                'updated_at' => $shipment->updated_at,
            ];
        });
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

            'name' => $shipment->name,

            'status' => $shipment->status,

            'created_at' => $shipment->created_at,

            'updated_at' => $shipment->updated_at,
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
