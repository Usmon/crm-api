<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Order;

use App\Models\Status;

use App\Models\Delivery;

use App\Models\Shipment;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Statuses as StatusesRequest;

final class Statuses
{
    /**
     * @param StatusesRequest $request
     *
     * @return array
     */
    public function getAllFilters(StatusesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'model' => $request->json('model'),

            'key' => $request->json('key'),

            'value' => $request->json('value'),

            'parameters' => $request->json('parameters'),
        ];
    }

    /**
     * @param StatusesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(StatusesRequest $request): array
    {
        return $request->only('search', 'date', 'model', 'key', 'value', 'parameters');
    }

    /**
     * @param StatusesRequest $request
     *
     * @return array
     */
    public function getAllSorts(StatusesRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param StatusesRequest $request
     *
     * @return array
     */
    public function getOnlySorts(StatusesRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getStatuses(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Status $status) {
            return [
                'id' => $status->id,

                'model' => $status->model,

                'key' => $status->key,

                'value' => $status->value,

                'image' => $status->image,

                'parameters' => $status->parameters,

                'created_at' => $status->created_at,

                'updated_at' => $status->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param Status $status
     *
     * @return array
     */
    public function showStatus(Status $status): array
    {
        return [
            'id' => $status->id,

            'model' => $status->model,

            'key' => $status->key,

            'value' => $status->value,

            'image' => $status->image,

            'parameters' => $status->parameters,

            'created_at' => $status->created_at,

            'updated_at' => $status->updated_at,
        ];
    }

    /**
     * @param StatusesRequest $request
     *
     * @return array
     */
    public function storeCredentials(StatusesRequest $request): array
    {
        return [
            'model' => $request->json('model'),

            'key' => $request->json('key'),

            'value' => $request->json('value'),

            'parameters' => json_encode($request->json('parameters')),

            'image' => $request->json('image'),
        ];
    }

    /**
     * @param StatusesRequest $request
     *
     * @return array
     */
    public function updateCredentials(StatusesRequest $request): array
    {
        return [
            'model' => $request->json('model'),

            'key' => $request->json('key'),

            'value' => $request->json('value'),

            'parameters' => json_encode($request->json('parameters')),

            'image' => $request->json('image'),
        ];
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteStatus($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int') === $id) ? $id : 0;
    }

    /**
     * @return array
     */
    public function getStatusDeliveries(): array
    {
        return Delivery::STATUSES;
    }

    /**
     * @return array
     */
    public function getStatusOrders(): array
    {
        return Order::STATUSES;
    }

    /**
     * @return array
     */
    public function getPaymentStatusOrders(): array
    {
        return Order::PAYMENT_STATUSES;
    }

    /**
     * @return array
     */
    public function getStatusShipments(): array
    {
        return Shipment::STATUSES;
    }
}
