<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Sender;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Senders as SendersRequest;

final class Senders
{
    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function getAllFilters(SendersRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'customer_id' => $request->json('customer_id'),

            'region_id' => $request->json('region_id'),

            'city_id' => $request->json('city_id'),

            'address_id' => $request->json('address_id'),

            'customer' => $request->json('customer'),

            'region' => $request->json('region'),

            'city' => $request->json('city'),

            'address' => $request->json('address'),
        ];
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(SendersRequest $request): array
    {
        return $request->only('search', 'date', 'customer_id',
            'region_id', 'city_id', 'address_id', 'customer', 'region', 'city', 'address');
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function getAllSorts(SendersRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function getOnlySorts(SendersRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getSenders(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Sender $sender) {
            return [
                'id' => $sender->id,

                'customer_id' => $sender->customer_id,

                'region_id' => $sender->region_id,

                'city_id' => $sender->city_id,

                'address_id' => $sender->address_id,

                'created_at' => $sender->created_at,

                'updated_at' => $sender->updated_at,

                'customer' => $sender->customer,

                'region' => $sender->region,

                'city' => $sender->city,

                'address' => $sender->address,
            ];
        });

        return $paginator;
    }

    /**
     * @param Sender $sender
     *
     * @return array
     */
    public function showSender(Sender $sender): array
    {
        return [
            'id' => $sender->id,

            'customer_id' => $sender->customer_id,

            'region_id' => $sender->region_id,

            'city_id' => $sender->city_id,

            'address_id' => $sender->address_id,

            'created_at' => $sender->created_at,

            'updated_at' => $sender->updated_at,

            'customer' => $sender->customer,

            'region' => $sender->region,

            'city' => $sender->city,

            'address' => $sender->address,
        ];
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function storeCredentials(SendersRequest $request): array
    {
        return [
            'customer_id' => $request->json('customer_id'),

            'region_id' => $request->json('region_id'),

            'city_id' => $request->json('city_id'),

            'address_id' => $request->json('address_id'),
        ];
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function updateCredentials(SendersRequest $request): array
    {
        return [
            'customer_id' => $request->json('customer_id'),

            'region_id' => $request->json('region_id'),

            'city_id' => $request->json('city_id'),

            'address_id' => $request->json('address_id'),
        ];
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteSender($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
