<?php

namespace App\Logic\Dashboard\CRUD\Services;

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

                'created_at' => $pickup->created_at,

                'status' => [
                    'id' => $pickup->status->id,

                    'name' => $pickup->status->value,

                    'color' => [
                        'bg' => $pickup->status->parameters->color->bg,

                        'text' => $pickup->status->parameters->color->text,
                    ],
                ],

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
            'total_boxes' => $pickup->orders->sum('total_boxes'),

            'total_orders' => $pickup->orders->count(),

            'total_customers' => $pickup->sender->count(),

            'total_picked_boxes' => 'total_picked_boxes',

            'created_at' => $pickup->created_at,

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

            'status' => [
                'id' => $pickup->status->id,

                'name' => $pickup->status->value,

                'color' => [
                    'bg' => $pickup->status->parameters->color->bg,

                    'text' => $pickup->status->parameters->color->text,
                ],
            ],

            'orders' => $pickup->orders->transform(function (Order $order) {
                return [
                    'id' => $order->id,

                    'total_boxes' => $order->total_boxes,

                    'total_products' => $order->products->count(),

                    'creator' => [
                        'id' => $order->staff->id,

                        'name' => $order->staff->profile['first_name'].' '.$order->staff->profile['last_name'].' '.$order->staff->profile['middle_name']
                    ],

                    'sender' => [
                        'id' => $order->sender->id,

                        'name' => $order->sender->customer->user->profile['first_name'].' '.$order->sender->customer->user->profile['last_name'].' '.$order->sender->customer->user->profile['middle_name'],

                        'address' => $order->sender->customer->user->addresses[0]['first_address'],

                        'phones' => collect($order->sender->customer->user()->get()->first()->phones()->latest('id')->limit(3)->get(['phone'])->toArray())
                            ->flatten()
                    ],

                    'status' => [
                        'id' => $order->status->id,

                        'name' => $order->status->value,

                        'color' => [
                            'bg' => $order->status->parameters->color->bg,

                            'text' => $order->status->parameters->color->text,
                        ],
                    ],
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
