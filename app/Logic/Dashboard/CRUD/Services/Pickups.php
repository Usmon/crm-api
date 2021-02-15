<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Pickup;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Pickups as PickupsRequest;

final class Pickups
{
    /**
     * @param PickupsRequest $request
     *
     * @return array
     */
    public function getAllFilters(PickupsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'pickup_datetime_start' => $request->json('pickup_datetime_start'),

            'pickup_datetime_end' => $request->json('pickup_datetime_end'),

            'status' => $request->json('status'),

            'sender_id' => $request->json('sender_id'),

            'driver_id' => $request->json('driver_id'),

            'creator_id' => $request->json('creator_id'),

            'sender' => $request->json('sender'),

            'driver' => $request->json('driver'),

            'creator' => $request->json('creator'),
        ];
    }

    /**
     * @param PickupsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(PickupsRequest $request): array
    {
        return $request->only('search', 'date', 'pickup_datetime_start', 'pickup_datetime_end',
            'status', 'driver_id', 'customer_id', 'customer', 'driver', 'creator');
    }

    /**
     * @param PickupsRequest $request
     *
     * @return array
     */
    public function getAllSorts(PickupsRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param PickupsRequest $request
     *
     * @return array
     */
    public function getOnlySorts(PickupsRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getPickups(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Pickup $pickup) {
            return [
                'id' => $pickup->id,

                'pickup_datetime_start' => $pickup->pickup_datetime_start,

                'pickup_datetime_end' => $pickup->pickup_datetime_end,

                'status_id' => $pickup->status_id,

                'sender_id' => $pickup->customer_id,

                'driver_id' => $pickup->driver_id,

                'creator_id' => $pickup->creator_id,

                'created_at' => $pickup->created_at,

                'updated_at' => $pickup->updated_at,

                'status' => $pickup->status,

                'customer' => $pickup->customer,

                'driver' => $pickup->driver,

                'creator' => $pickup->creator,

                'orders' => $pickup->orders,
            ];
        });

        return $paginator;
    }

    /**
     * @param Pickup $pickup
     *
     * @return array
     */
    public function showPickup(Pickup $pickup): array
    {
        return [
            'id' => $pickup->id,

            'pickup_datetime_start' => $pickup->pickup_datetime_start,

            'pickup_datetime_end' => $pickup->pickup_datetime_end,

            'status_id' => $pickup->status_id,

            'customer_id' => $pickup->customer_id,

            'driver_id' => $pickup->driver_id,

            'creator_id' => $pickup->creator_id,

            'created_at' => $pickup->created_at,

            'updated_at' => $pickup->updated_at,

            'status' => $pickup->status,

            'sender' => $pickup->customer,

            'driver' => $pickup->driver,

            'creator' => $pickup->creator,

            'orders' => $pickup->orders,

            'total_orders' => $pickup->totalOrders(),

            'total_boxes' => $pickup->totalBoxes(),

            'total_delivered_boxes' => $pickup->totalDeliveredBoxes(),
        ];
    }

    /**
     * @param PickupsRequest $request
     *
     * @return array
     */
    public function createPickup(PickupsRequest $request): array
    {
        return [
            'pickup_datetime_start' => $request->json('pickup_datetime_start'),

            'pickup_datetime_end' => $request->json('pickup_datetime_end'),

            'status_id' => $request->json('status_id'),

            'customer_id' => $request->json('customer_id'),

            'driver_id' => $request->json('driver_id'),
        ];
    }

    /**
     * @param PickupsRequest $request
     *
     * @return array
     */
    public function updatePickup(PickupsRequest $request): array
    {
        return [
            'pickup_datetime_start' => $request->json('pickup_datetime_start'),

            'pickup_datetime_end' => $request->json('pickup_datetime_end'),

            'status_id' => $request->json('status_id'),

            'customer_id' => $request->json('customer_id'),

            'driver_id' => $request->json('driver_id'),
        ];
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deletePickup($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
