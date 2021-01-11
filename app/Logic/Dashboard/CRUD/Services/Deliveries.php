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

            'customer_id' => $request->json('customer_id'),

            'status' => $request->json('status'),
        ];
    }

    /**
     * @param DeliveriesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(DeliveriesRequest $request): array
    {
        return $request->only('search', 'date', 'driver_id', 'customer_id', 'status');
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
        $paginator->getCollection()->transform( function (Delivery $delivery) {
            return [
                'id' => $delivery->id,

                'customer'=> $delivery->customer()->with(['phones'])->get(),

                'driver' => $delivery->driver,

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

            'customer'=> $delivery->customer()->with(['phones'])->get(),

            'driver' => $delivery->driver,

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
            'customer_id' => $request->json('customer_id'),

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
            'customer_id' => $request->json('customer_id'),

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
