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

            'customer_id' => $request->json('customer_id'),

            'address' => $request->json('address'),

            'customer' => $request->json('customer'),
        ];
    }

    /**
     * @param AddressesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(AddressesRequest $request): array
    {
        return $request->only('search', 'date', 'customer_id', 'address', 'customer');
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

                'customer_id' => $address->customer_id,

                'address' => $address->address,

                'created_at' => $address->created_at,

                'updated_at' => $address->updated_at,

                'customer' => $address->customer,
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

            'customer_id' => $address->customer_id,

            'address' => $address->address,

            'created_at' => $address->created_at,

            'updated_at' => $address->updated_at,

            'customer' => $address->customer,
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
            'customer_id' => $request->json('customer_id'),

            'address' => $request->json('address'),
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
            'customer_id' => $request->json('customer_id'),

            'address' => $request->json('address'),
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
