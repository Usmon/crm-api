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

            'name' => $request->json('name'),

            'phone' => $request->json('phone'),

            'email' => $request->json('email'),

            'region' => $request->json('region'),

            'city' => $request->json('city'),

            'zip_or_post_code' => $request->json('zip_or_post_code'),

            'address' => $request->json('address'),

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
    public function getOnlyFilters(DriversRequest $request): array
    {
        return $request->only('search', 'date', 'creator', 'name', 'phone', 'email', 'region', 'city',
                                    'zip_or_post_code', 'address', 'car_model', 'car_number', 'license');
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

                'name' => $driver->name,

                'phone' => $driver->phone,

                'email' => $driver->email,

                'region' => $driver->region,

                'city' => $driver->city,

                'zip_or_post_code' => $driver->zip_or_post_code,

                'address' => $driver->address,

                'car_model' => $driver->car_model,

                'car_number' => $driver->car_number,

                'license' => $driver->license,

                'created_at' => $driver->created_at,

                'updated_at' => $driver->updated_at,

                'creator' => $driver->creator,
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

            'name' => $driver->name,

            'phone' => $driver->phone,

            'email' => $driver->email,

            'region' => $driver->region,

            'city' => $driver->city,

            'zip_or_post_code' => $driver->zip_or_post_code,

            'address' => $driver->address,

            'car_model' => $driver->car_model,

            'car_number' => $driver->car_number,

            'license' => $driver->license,

            'created_at' => $driver->created_at,

            'updated_at' => $driver->updated_at,

            'creator' => $driver->creator,
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
            'name' => $request->json('name'),

            'phone' => $request->json('phone'),

            'email' => $request->json('email'),

            'region' => $request->json('region'),

            'city' => $request->json('city'),

            'zip_or_post_code' => $request->json('zip_or_post_code'),

            'address' => $request->json('address'),

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
            'name' => $request->json('name'),

            'phone' => $request->json('phone'),

            'email' => $request->json('email'),

            'region' => $request->json('region'),

            'city' => $request->json('city'),

            'zip_or_post_code' => $request->json('zip_or_post_code'),

            'address' => $request->json('address'),

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
