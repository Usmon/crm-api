<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Box;
use App\Models\Order;

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
            'status', 'driver_id', 'sender_id', 'sender', 'driver', 'creator');
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

                'created_at' => $pickup->created_at,

                'status' => $pickup->status->for_color,

                'range' => [
                    'from' => $pickup->pickup_datetime_start,

                    'to' => $pickup->pickup_datetime_end
                ],

                'sender' => [
                    'name' => $pickup->sender_name,

                    'phone' => $pickup->sender_phone,
                ],

                'creator' => [
                    'id' => $pickup->creator->id,

                    'name' => $pickup->creator_name,

                    'phone' => $pickup->creator_phone,
                ],

                'driver' => [
                    'id' => $pickup->driver->id,

                    'name' => $pickup->driver_name,

                    'phone' => $pickup->driver_phone,

                    'image' => $pickup->driver_image,
                ],
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

            'creator' => [
                'id' => $pickup->creator->id,

                'name' => $pickup->creator_name,
            ],

            'driver' => [
                'id' => $pickup->driver->id,

                'name' => $pickup->driver_name,

                'phone' => $pickup->driver_phone,
            ],

            'total_customers' => $pickup->sender->count(),

            'total_boxes' => $pickup->boxes()->count(),

            'total_picked_boxes' => $pickup->totalPickedBoxes(),

            'created_at' => $pickup->created_at,

            'status' => $pickup->status->for_color,

            'boxes' => $pickup->boxes->map(function (Box $box) {
                return [
                    'id' => $box->id,

                    'creator' => [
                        'id' => $box->creator['id'],

                        'name' => $box->creator['profile']['first_name'] . ' ' . $box->creator['profile']['last_name'] . ' ' . $box->creator['profile']['middle_name']
                    ],

                    'total_products' => $box->total_products,

                    'total_weight' => $box->items()->sum('weight'),

                    'total_price' => $box->items()->sum('price'),

                    'note' => $box->note,

                    'created_at' => $box->created_at,

                    'status' => [
                        'id' => 1,

                        'name' => $box->status->value,

                        'color' => [
                            'bg' => $box->status->parameters['color']['bg'],

                            'text' => $box->status->parameters['color']['text'],
                        ],
                    ]
                ];
            }),
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

            'sender_id' => $request->json('sender_id'),

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

            'sender_id' => $request->json('sender_id'),

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
