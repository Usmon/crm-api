<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Phone;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Phones as PhonesRequest;

final class Phones
{
    /**
     * @param PhonesRequest $request
     *
     * @return array
     */
    public function getAllFilters(PhonesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'customer_id' => $request->json('customer_id'),

            'phone' => $request->json('phone'),

            'customer' => $request->json('customer'),
        ];
    }

    /**
     * @param PhonesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(PhonesRequest $request): array
    {
        return $request->only('search', 'date', 'customer_id', 'phone', 'customer');
    }

    /**
     * @param PhonesRequest $request
     *
     * @return array
     */
    public function getAllSorts(PhonesRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param PhonesRequest $request
     *
     * @return array
     */
    public function getOnlySorts(PhonesRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getPhones(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Phone $phone) {
            return [
                'id' => $phone->id,

                'customer_id' => $phone->customer_id,

                'phone' => $phone->phone,

                'created_at' => $phone->created_at,

                'updated_at' => $phone->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param Phone $phone
     *
     * @return array
     */
    public function showPhone(Phone $phone): array
    {
        return [
            'id' => $phone->id,

            'customer_id' => $phone->customer_id,

            'phone' => $phone->phone,

            'created_at' => $phone->created_at,

            'updated_at' => $phone->updated_at,
        ];
    }

    /**
     * @param PhonesRequest $request
     *
     * @return array
     */
    public function storeCredentials(PhonesRequest $request): array
    {
        return [
            'customer_id' => $request->json('customer_id'),

            'phone' => $request->json('phone'),
        ];
    }

    /**
     * @param PhonesRequest $request
     *
     * @return array
     */
    public function updateCredentials(PhonesRequest $request): array
    {
        $credentials = [
            'customer_id' => $request->json('customer_id'),

            'phone' => $request->json('phone'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deletePhone($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
