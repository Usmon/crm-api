<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Box;

use App\Models\BoxItem;
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

            'index' => $request->json('index'),

            'status_id' => $request->json('status_id'),
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
            'status', 'driver_id', 'sender_id', 'sender', 'driver', 'creator', 'index', 'pickup_id', 'status_id');
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
                    'from' => json_decode($pickup['type'])->date->from,

                    'to' => json_decode($pickup['type'])->date->to,
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

                        'name' => $box->creator['profile']['first_name']
                            . ' ' . $box->creator['profile']['last_name']
                            . ' ' . $box->creator['profile']['middle_name']
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
        $credentials = [
            'type' => json_encode($request->json('type')),

            'status_id' => $request->json('status_id'),

            'sender_id' => $request->json('sender_id'),

            'driver_id' => $request->json('driver_id'),

            'price' => $request->json('price') ?? 0,

            'boxes' => $request->json('boxes'),

            'products' => $request->json('boxes.*.products'),
        ];

        return $credentials;
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

            'price' => $request->json('price') ?? 0,
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

    public function updateShow(Pickup $pickup)
    {
        return [
            'id' => $pickup->id,

            'status_id' => $pickup->status_id,

            'sender' => [
                'id' => $pickup->sender->id,

                'sender_full_name' => $pickup->sender->customer->user->full_name,

                'sender_phone' => $pickup->sender->customer->user->phones[0]['phone'],

                'sender_email' => $pickup->sender->customer->user->email,

                'sender_region' => $pickup->sender->customer->user->addresses[0]['city']['region']['name'],

                'sender_city' => $pickup->sender->customer->user->addresses[0]['city']['name'],

                'sender_zip_code' => $pickup->sender->customer->user->addresses[0]['city']['region']['zip_code'],

                'sender_address_line_1' => $pickup->sender->customer->user->addresses[0]['first_address'],

                'sender_address_line_2' => $pickup->sender->customer->user->addresses[0]['second_address'],
            ],

            'driver' => [
                'id' => $pickup->driver->id,

                'driver_full_name' => $pickup->driver->user->full_name,

                'driver_phone' => $pickup->driver->user->phones[0]['phone'] ?? '',

                'driver_email' => $pickup->driver->user->email,

                'driver_region' => $pickup->driver->user->addresses[0]['city']['region']['name'] ?? '',

                'driver_city' => $pickup->driver->user->addresses[0]['city']['name'] ?? '',

                'driver_zip_code' => $pickup->driver->user->addresses[0]['city']['region']['zip_code'] ?? '',

                'driver_address_line_1' => $pickup->driver->user->addresses[0]['first_address'] ?? '',

                'driver_address_line_2' => $pickup->driver->user->addresses[0]['second_address'] ?? '',

                'car_number' => $pickup->driver->car_number,

                'car_model' => $pickup->driver->car_model,

                'license' => $pickup->driver->license,
            ],

            'type' => [
                'index' => json_decode($pickup->type)->index,

                'date' => [
                    'from' =>  json_decode($pickup->type)->date->from,

                    'to' =>  json_decode($pickup->type)->date->to,
                ],
            ],

            'boxes' => $pickup->boxes->map(function (Box $box) {
                return[
                    'id' => $box->id,

                    'creator' => $box->creator->full_name,

                    'created_at' => $box->created_at,

                    'total_weight' => $box->weight,

                    'total_products' => $box->items()->count(),

                    'total_price' => $box->items()->sum('price'),

                    'note' => $box->note,

                    'status' => $box->status->for_color,

                    'products' => $box->items->map(function (BoxItem $boxItem) {
                        return[
                            'id' => $boxItem->id,

                            'name' => $boxItem->name,

                            'quantity' => $boxItem->quantity,

                            'price' => $boxItem->price,

                            'weight' => $boxItem->weight,

                            'type_weight' => $boxItem->type_weight,

                            'note' => $boxItem->note,

                            'image' => $boxItem->image,
                        ];
                    }),
                ];
            }),
        ];
    }

    public function updateStatus(PickupsRequest $request)
    {
        return [
            'status_id' => $request->json('status_id'),
        ];
    }
}
