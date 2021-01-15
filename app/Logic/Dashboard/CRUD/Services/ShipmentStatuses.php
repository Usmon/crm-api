<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\ShipmentStatus;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\ShipmentStatuses as ShipmentStatusesRequest;

final class ShipmentStatuses
{
    /**
     * @param ShipmentStatusesRequest $request
     *
     * @return array
     */
    public function getAllFilters(ShipmentStatusesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'name' => $request->json('name'),
        ];
    }

    /**
     * @param ShipmentStatusesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(ShipmentStatusesRequest $request): array
    {
        return $request->only('search', 'date', 'name',);
    }

    /**
     * @param ShipmentStatusesRequest $request
     *
     * @return array
     */
    public function getAllSorts(ShipmentStatusesRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param ShipmentStatusesRequest $request
     *
     * @return array
     */
    public function getOnlySorts(ShipmentStatusesRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getShipmentStatuses(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (ShipmentStatus $shipmentStatus) {
            return [
                'id' => $shipmentStatus->id,

                'name' => $shipmentStatus->name,

                'color' => $shipmentStatus->color,

                'created_at' => $shipmentStatus->created_at,

                'updated_at' => $shipmentStatus->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param ShipmentStatus $status
     *
     * @return array
     */
    public function showShipmentStatus(ShipmentStatus $status): array
    {
        return [
            'id' => $status->id,

            'name' => $status->name,

            'color' => $status->color,

            'created_at' => $status->created_at,

            'updated_at' => $status->updated_at,
        ];
    }

    /**
     * @param ShipmentStatusesRequest $request
     *
     * @return array
     */
    public function storeCredentials(ShipmentStatusesRequest $request): array
    {
        return [
            'name' => $request->json('name'),

            'color' => $request->json('color'),
        ];
    }

    /**
     * @param ShipmentStatusesRequest $request
     *
     * @return array
     */
    public function updateCredentials(ShipmentStatusesRequest $request): array
    {
        $credentials = [
            'name' => $request->json('name'),

            'color' => $request->json('color'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteShipmentStatus($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
