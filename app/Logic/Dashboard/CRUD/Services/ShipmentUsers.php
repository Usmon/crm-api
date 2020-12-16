<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\ShipmentUser;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\ShipmentUsers as ShipmentUsersRequest;

final class ShipmentUsers
{
    /**
     * @param ShipmentUsersRequest $request
     *
     * @return array
     */
    public function getAllFilters(ShipmentUsersRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'user_id' => $request->json('user_id'),

            'shipment_id' => $request->json('shipment_id')
        ];
    }

    /**
     * @param ShipmentUsersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(ShipmentUsersRequest $request): array
    {
        return $request->only('search', 'date', 'user_id', 'shipment_id');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getShipmentUsers(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (ShipmentUser $shipmentUser) {
            return [
                'id' => $shipmentUser->id,

                'user_id' => $shipmentUser->user_id,

                'shipment_id' => $shipmentUser->shipment_id,

                'created_at' => $shipmentUser->updated_at,

                'updated_at' => $shipmentUser->updated_at,

                'user' => $shipmentUser->user,

                'shipment' => $shipmentUser->shipment,
            ];
        });

        return $paginator;
    }

    /**
     * @param ShipmentUser $shipmentUser
     *
     * @return array
     */
    public function showShipmentUser(ShipmentUser $shipmentUser): array
    {
        return [
            'id' => $shipmentUser->id,

            'user_id' => $shipmentUser->user_id,

            'shipment_id' => $shipmentUser->shipment_id,

            'created_at' => $shipmentUser->created_at,

            'updated_at' => $shipmentUser->updated_at,

            'user' => $shipmentUser->user,

            'shipment' => $shipmentUser->shipment,
        ];
    }

    /**
     * @param ShipmentUsersRequest $request
     *
     * @return array
     */
    public function storeCredentials(ShipmentUsersRequest $request): array
    {
        return [
            'user_id' => $request->json('user_id'),

            'shipment_id' => $request->json('shipment_id'),
        ];
    }

    /**
     * @param ShipmentUsersRequest $request
     *
     * @return array
     */
    public function updateCredentials(ShipmentUsersRequest $request): array
    {
        $credentials = [
            'user_id' => $request->json('user_id'),

            'shipment_id' => $request->json('shipment_id')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteShipmentUser($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
