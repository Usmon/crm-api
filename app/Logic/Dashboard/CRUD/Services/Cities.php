<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\City;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Cities as CitiesRequest;

final class Cities
{
    /**
     * @param   CitiesRequest $request
     *
     * @return array
    */
    public function getAllFilters(CitiesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'region_id' => $request->json('region_id'),

            'region' => $request->json('region'),

            'name' => $request->json('name'),

            'code' => $request->json('code')
        ];
    }

    /**
     * @param CitiesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(CitiesRequest $request): array
    {
        return $request->only('search', 'region', 'region_id', 'name', 'code');
    }

    /**
     * @param CitiesRequest $request
     *
     * @return array
     */
    public function getAllSorts(CitiesRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param CitiesRequest $request
     *
     * @return array
     */
    public function getOnlySorts(CitiesRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getCities(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (City $city) {
            return [
                'id' => $city->id,

                'region' => [
                    'id' => $city->region->id,

                    'name' => $city->region->name,
                ],

                'name' => $city->name,

                'codes' => $city->codes
            ];
        });

        return $paginator;
    }

    /**
     * @param City $city
     *
     * @return array
     */
    public function showCity(City $city): array
    {
        return [
            'id' => $city->id,

            'region_id' => $city->region_id,

            'name' => $city->name,

            'created_at' => $city->created_at,

            'updated_at' => $city->updated_at,

            'addresses' => $city->addresses,
        ];
    }

    /**
     * @param CitiesRequest $request
     *
     * @return array
     */
    public function storeCredentials(CitiesRequest $request): array
    {
        return [
            'region_id' => $request->json('region_id'),

            'name' => $request->json('name'),
        ];
    }

    /**
     * @param CitiesRequest $request
     *
     * @return array
     */
    public function updateCredentials(CitiesRequest $request): array
    {
        $credentials = [
            'region_id' => $request->json('region_id'),

            'name' => $request->json('name'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteCity($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
