<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\ShipmentComment;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\ShipmentComments as ShipmentCommentsRequest;

final class ShipmentComments
{
    /**
     * @param ShipmentCommentsRequest $request
     *
     * @return array
     */
    public function getAllFilters(ShipmentCommentsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'shipment_id' => $request->json('shipment_id'),

            'comment' => $request->json('comment'),
        ];
    }

    /**
     * @param ShipmentCommentsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(ShipmentCOmmentsRequest $request): array
    {
        return $request->only('search', 'date', 'shipment_id', 'comment');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getShipmentComments(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (ShipmentComment $shipmentComment) {
            return [
                'id' => $shipmentComment->id,

                'shipment_id' => $shipmentComment->shipment_id,

                'comment' => $shipmentComment->comment,

                'created_at' => $shipmentComment->created_at,

                'updated_at' => $shipmentComment->updated_at,

                'shipment' => $shipmentComment->shipment,
            ];
        });

        return $paginator;
    }

    /**
     * @param ShipmentComment $shipmentComment
     *
     * @return array
     */
    public function showShipmentComment(ShipmentComment $shipmentComment): array
    {
        return [
            'id' => $shipmentComment->id,

            'shipment_id' => $shipmentComment->shipment_id,

            'comment' => $shipmentComment->comment,

            'created_at' => $shipmentComment->created_at,

            'updated_at' => $shipmentComment->updated_at,

            'shipment' => $shipmentComment->shipment,
        ];
    }

    /**
     * @param ShipmentCommentsRequest $request
     *
     * @return array
     */
    public function storeCredentials(ShipmentCommentsRequest $request): array
    {
        return [
            'shipment_id' => $request->json('shipment_id'),

            'comment' => $request->json('comment'),
        ];
    }

    /**
     * @param ShipmentCommentsRequest $request
     *
     * @return array
     */
    public function updateCredentials(ShipmentCommentsRequest $request): array
    {
        $credentials = [
            'shipment_id' => $request->json('shipment_id'),

            'owner_id' => $request->json('owner_id'),

            'comment' => $request->json('comment'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteShipmentComment($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
