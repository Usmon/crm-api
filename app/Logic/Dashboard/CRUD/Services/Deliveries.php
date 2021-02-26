<?php

namespace App\Logic\Dashboard\CRUD\Services;

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

                'total_orders' => $delivery->orders->count(),

                'total_delivered_orders' => $delivery->totalDeliveredOrders(),

                'total_products' => $delivery->totalProducts(),

                'created_at' => $delivery->created_at,

                'status' => $delivery->status,

                'creator' => [
                    'id' => $delivery->creator->id,

                    'name' => $delivery->creatorName(),

                    'image' => $delivery->creatorImage(),

                    'phones' => $delivery->creatorPhones(),
                ],

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

            'total_orders' => $delivery->orders->count(),

            'total_delivered_orders' => $delivery->totalDeliveredOrders(),

            'total_products' => $delivery->totalProducts(),

            'created_at' => $delivery->created_at,

            'status' => $delivery->status,

            'creator' => [
                'id' => $delivery->creator->id,

                'name' => $delivery->creatorName(),

                'image' => $delivery->creatorImage(),

                'phones' => $delivery->creatorPhones(),
            ],

            'driver' => [
                'id' => $delivery->driver->id,

                'name' => $delivery->driverName(),

                'image' => $delivery->driverImage(),

                'phones' => $delivery->driverPhones(),
            ],
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
}
