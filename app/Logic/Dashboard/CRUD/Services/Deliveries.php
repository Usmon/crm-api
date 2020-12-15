<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Delivery;

use App\Logic\Dashboard\CRUD\Requests\Deliveries as DeliveriesRequest;

use Illuminate\Support\Arr;

use Illuminate\Contracts\Pagination\Paginator;

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
        ];
    }

    /**
     * @param DeliveriesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(DeliveriesRequest $request): array
    {
        return $request->only('search', 'date');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getDeliveries(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform( function (Delivery $delivery) {
            return [
                'id' => $delivery->id,

                'customer' => $delivery->orders->customer_id,

                'driver' => $delivery->users->login,

                'status' => $delivery->status,

                'created_at' => $delivery->created_at,

                'updated_at' => $delivery->updated_at,
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

            'customer' => $delivery->orders->customer_id,

            'driver' => $delivery->users->login,

            'status' => $delivery->status,

            'created_at' => $delivery->created_at,

            'updated_at' => $delivery->updated_at,

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
            'order_id' => $request->json('order_id'),

            'driver_id' => $request->json('driver_id'),

            'status' => $request->json('status'),
        ];
    }

    /**
     * @param DeliveriesRequest $request
     *
     * @return array
     */
    public function updateDelivery(DeliveriesRequest $request): array
    {
        $deliveries = [
            'order_id' => $request->json('order_id'),

            'driver_id' => $request->json('driver_id'),

            'status' => $request->json('status'),
        ];

        return $deliveries;
    }

    /**
     * @param $id
     */
    public function deleteDelivery($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int') === $id) ? $id : 0;
    }
}
