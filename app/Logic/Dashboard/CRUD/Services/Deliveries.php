<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Box;

use App\Models\BoxItem;
use App\Models\Delivery;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Deliveries as DeliveriesRequest;

final class Deliveries
{
    /**
     * @param DeliveriesRequest $request
     *
     * @return array
     */
    public function getAllFilters(DeliveriesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'driver_id' => $request->json('driver_id'),

            'recipient_id' => $request->json('recipient_id'),

            'status_id' => $request->json('status_id'),

            'status' => $request->json('status'),

            'recipient' => $request->json('recipient'),

            'driver' => $request->json('driver'),

            'creator_id' => $request->json('creator_id'),

            'creator' => $request->json('creator'),
        ];
    }

    /**
     * @param DeliveriesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(DeliveriesRequest $request): array
    {
        return $request->only('search', 'date', 'driver_id', 'recipient_id', 'status_id',
            'status', 'recipient', 'driver', 'creator_id', 'creator');
    }

    /**
     * @param DeliveriesRequest $request
     *
     * @return array
     */
    public function getAllSorts(DeliveriesRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param DeliveriesRequest $request
     *
     * @return array
     */
    public function getOnlySorts(DeliveriesRequest $request): array
    {
        return $request->only('sort');
    }
    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getDeliveries(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Delivery $delivery) {
            return [
                'id' => $delivery->id,

                'total_boxes' => $delivery->boxes->count(),

                'total_products' => $delivery->totalProducts(),

                'total_delivered_boxes' => $delivery->totalDeliveredBoxes($delivery->id),

                'created_at' => $delivery->created_at,

                'status' => $delivery->status->for_color,

                'creator' => $delivery->creator->short_info,

                'driver' => [
                    'id' => $delivery->driver->id,

                    'name' => $delivery->driverName(),

                    'image' => $delivery->driverImage(),

                    'phones' => $delivery->driverPhones(),
                ],
            ];
        });

        return $paginator;
    }

    /**
     * @param Delivery $delivery
     *
     * @return array
     */
    public function showDelivery(Delivery $delivery): array
    {
        return [
            'id' => $delivery->id,

            'creator' => [
                'id' => $delivery->creator->id,

                'name' => $delivery->creatorName(),
            ],

            'driver' => [
                'id' => $delivery->driver->id,

                'name' => $delivery->driverName(),

                'phones' => $delivery->driverPhones(),
            ],

            'total_customers' => $delivery->recipient()->count(),

            'total_boxes' => $delivery->totalBoxes(),

            'total_delivered_products' => $delivery->totalDeliveredBoxes($delivery->id),

            'created_at' => $delivery->created_at,

            'status' => [
                'id' => $delivery->id,

                'name' => $delivery->status->value,

                'color' => [
                    'bg' => $delivery->status['parameters']['color']['bg'],

                    'color' => $delivery->status['parameters']['color']['text'],
                ],
            ],

            'boxes' => $delivery->boxes->map(function (Box $box) {
                return [
                    'id' => $box->id,

                    'creator' => [
                        'id' => $box->creator->id,

                        'name' => $box->creator['profile']['first_name']

                            . ' ' . $box->creator['profile']['last_name']

                            . ' ' . $box->creator['profile']['middle_name']
                    ],

                    'total_products' => $box->items()->count(),

                    'total_weight' => $box->items()->sum('weight'),

                    'total_price' => $box->items()->sum('price'),

                    'note' => $box->note,

                    'created_at' => $box->created_at,

                    'status' => [
                        'id' => $box->status->id,

                        'name' => $box->status->value,

                        'color' => [
                            'bg' => $box->status['parameters']['color']['bg'],

                            'color' => $box->status['parameters']['color']['text'],
                        ],
                    ],
                ];
            }),
        ];
    }

    /**
     * @param DeliveriesRequest $request
     *
     * @return array
     */
    public function createDelivery(DeliveriesRequest $request): array
    {
        return [
            'recipient_id' => $request->json('recipient_id'),

            'driver_id' => $request->json('driver_id'),

            'status_id' => $request->json('status_id'),

            'boxes' => $request->json('boxes'),
        ];
    }

    /**
     * @param DeliveriesRequest $request
     *
     * @return array
     */
    public function updateDelivery(DeliveriesRequest $request): array
    {
        $delivery = [
            'recipient_id' => $request->json('recipient_id'),

            'driver_id' => $request->json('driver_id'),

            'status_id' => $request->json('status_id'),

            'boxes' => $request->json('boxes'),
        ];

        return $delivery;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteDelivery($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int') === $id) ? $id : 0;
    }

    /**
     * @param Delivery $delivery
     * @return array
     */
    public function updateShow(Delivery $delivery)
    {
        return [
            'id' => $delivery->id,

            'status_id' => $delivery->status_id,

            'recipient' => [
                'id' => $delivery->recipient->id,

                'recipient_full_name' => $delivery->recipient->customer->user->full_name,

                'recipient_phone' => $delivery->recipient->customer->user->phones[0]['phone'],

                'recipient_email' => $delivery->recipient->customer->user->email,

                'recipient_region' => $delivery->recipient->customer->user->addresses[0]['city']['region']['name'],

                'recipient_city' => $delivery->recipient->customer->user->addresses[0]['city']['name'],

                'recipient_zip_code' => $delivery->recipient->customer->user->addresses[0]['city']['region']['zip_code'],

                'recipient_address_line_1' => $delivery->recipient->customer->user->addresses[0]['first_address'],

                'recipient_address_line_2' => $delivery->recipient->customer->user->addresses[0]['second_address'],

                'recipient_limit' => $delivery->recipient->limit,
            ],

            'driver' => [
                'id' => $delivery->driver->id,

                'driver_full_name' => $delivery->driver->user->full_name,

                'driver_phone' => $delivery->driver->user->phones[0]['phone'],

                'driver_email' => $delivery->driver->user->email,

                'driver_region' => $delivery->driver->user->addresses[0]['city']['region']['name'] ?? '',

                'driver_city' => $delivery->driver->user->addresses[0]['city']['name'] ?? '',

                'driver_zip_code' => $delivery->driver->user->addresses[0]['city']['region']['zip_code'] ?? '',

                'driver_address_line_1' => $delivery->driver->user->addresses[0]['first_address'] ?? '',

                'driver_address_line_2' => $delivery->driver->user->addresses[0]['second_address'] ?? '',

                'car_number' => $delivery->driver->car_number,

                'car_model' => $delivery->driver->car_model,

                'license' => $delivery->driver->license,
            ],

            'boxes' => $delivery->boxes->map(function (Box $box) {
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

    public function updateStatus(DeliveriesRequest $request)
    {
        return [
            'status_id' => $request->json('status_id'),
        ];
    }
}
