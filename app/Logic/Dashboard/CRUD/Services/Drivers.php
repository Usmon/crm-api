<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Driver;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Drivers as DriversRequest;

final class Drivers
{
    /**
     * @param DriversRequest $request
     *
     * @return array
     */
    public function getAllFilters(DriversRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'creator' => $request->json('creator'),

            'user_id' => $request->json('user_id'),

            'region_id' => $request->json('region_id'),

            'city_id' => $request->json('city_id'),

            'address_id' => $request->json('address_id'),

            'region' => $request->json('region'),

            'city' => $request->json('city'),

            'address' => $request->json('address'),

            'car_model' => $request->json('car_model'),

            'car_number' => $request->json('car_number'),

            'license' => $request->json('license'),

            'user' => $request->json('user'),
        ];
    }

    /**
     * @param DriversRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(DriversRequest $request): array
    {
        return $request->only('search', 'date', 'creator', 'user_id', 'region_id',
            'city_id',  'address_id', 'region', 'city',  'address', 'car_model', 'car_number', 'license', 'user');
    }

    /**
     * @param DriversRequest $request
     *
     * @return array
     */
    public function getAllSorts(DriversRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param DriversRequest $request
     *
     * @return array
     */
    public function getOnlySorts(DriversRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getDrivers(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Driver $driver) {
            return [
                'id' => $driver->id,

                'user_id' => $driver->user_id,

                'region_id' => $driver->region_id,

                'city_id' => $driver->city_id,

                'address_id' => $driver->address_id,

                'car_model' => $driver->car_model,

                'car_number' => $driver->car_number,

                'license' => $driver->license,

                'created_at' => $driver->created_at,

                'updated_at' => $driver->updated_at,

                'creator' => $driver->creator,

                'user' => $driver->user,

                'region' => $driver->region,

                'city' => $driver->city,

                'address' => $driver->address,
            ];
        });

        return $paginator;
    }

    /**
     * @param Driver $driver
     *
     * @return array
     */
    public function showDriver(Driver $driver): array
    {
        return [
            'id' => $driver->id,

            'user_id' => $driver->user_id,

            'region_id' => $driver->region_id,

            'city_id' => $driver->city_id,

            'address_id' => $driver->address_id,

            'car_model' => $driver->car_model,

            'car_number' => $driver->car_number,

            'license' => $driver->license,

            'created_at' => $driver->created_at,

            'updated_at' => $driver->updated_at,

            'creator' => $driver->creator,

            'user' => $driver->user,

            'region' => $driver->region,

            'city' => $driver->city,

            'address' => $driver->address,
        ];
    }

    /**

     * @param DriversRequest $request
     *
     * @return array
     */
    public function storeCredentials(DriversRequest $request): array
    {
        return [
            'user_id' => $request->json('user_id'),

            'region_id' => $request->json('region_id'),

            'city_id' => $request->json('city_id'),

            'address_id' => $request->json('address_id'),

            'car_model' => $request->json('car_model'),

            'car_number' => $request->json('car_number'),

            'license' => $request->json('license'),
        ];
    }

    /**
     * @param DriversRequest $request
     *
     * @return array
     */
    public function updateCredentials(DriversRequest $request): array
    {
        return [
            'user_id' => $request->json('user_id'),

            'region_id' => $request->json('region_id'),

            'city_id' => $request->json('city_id'),

            'address_id' => $request->json('address_id'),

            'car_model' => $request->json('car_model'),

            'car_number' => $request->json('car_number'),

            'license' => $request->json('license'),
        ];
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteDriver($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
