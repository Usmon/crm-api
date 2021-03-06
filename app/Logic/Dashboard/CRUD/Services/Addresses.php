<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Address;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Addresses as AddressesRequest;

final class Addresses
{
    /**
     * @param AddressesRequest $request
     *
     * @return array
     */
    public function getAllFilters(AddressesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'user_id' => $request->json('user_id'),

            'city_id' => $request->json('city_id'),

            'first_address' => $request->json('first_address'),

            'second_address' => $request->json('second_address'),

            'user' => $request->json('user'),

            'city' => $request->json('city'),
        ];
    }

    /**
     * @param AddressesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(AddressesRequest $request): array
    {
        return $request->only('search', 'date', 'user_id', 'city_id', 'first_address', 'second_address', 'user', 'city');
    }

    /**
     * @param AddressesRequest $request
     *
     * @return array
     */
    public function getAllSorts(AddressesRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param AddressesRequest $request
     *
     * @return array
     */
    public function getOnlySorts(AddressesRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getAddresses(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Address $address) {
            return [
                'id' => $address->id,

                'user_id' => $address->user_id,

                'city_id' => $address->city_id,

                'first_address' => $address->first_address,

                'second_address' => $address->second_address,

                'created_at' => $address->created_at,

                'updated_at' => $address->updated_at,

                'user' => $address->user,

                'city' => $address->city,
            ];
        });

        return $paginator;
    }

    /**
     * @param Address $address
     *
     * @return array
     */
    public function showAddress(Address $address): array
    {
        return [
            'id' => $address->id,

            'user_id' => $address->user_id,

            'city_id' => $address->city_id,

            'first_address' => $address->first_address,

            'second_address' => $address->second_address,

            'created_at' => $address->created_at,

            'updated_at' => $address->updated_at,

            'user' => $address->user,

            'city' => $address->city,
        ];
    }

    /**
     * @param AddressesRequest $request
     *
     * @return array
     */
    public function storeCredentials(AddressesRequest $request): array
    {
        return [
            'user_id' => $request->json('user_id'),

            'city_id' => $request->json('city_id'),

            'first_address' => $request->json('first_address'),

            'second_address' => $request->json('second_address'),
        ];
    }

    /**
     * @param AddressesRequest $request
     *
     * @return array
     */
    public function updateCredentials(AddressesRequest $request): array
    {
        $credentials = [
            'user_id' => $request->json('user_id'),

            'city_id' => $request->json('city_id'),

            'first_address' => $request->json('first_address'),

            'second_address' => $request->json('second_address'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteAddress($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
