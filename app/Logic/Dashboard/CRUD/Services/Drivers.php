<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Driver;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Drivers as DriversRequest;
use Illuminate\Support\Collection;

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
        return $request->only('search', 'date', 'creator', 'user_id', 'car_model', 'car_number', 'license', 'user');
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

                'user' => [
                    'full_name' => $driver->user->full_name,

                    'login' => $driver->user->login,

                    'email' => $driver->user->email,

                    'photo' => $driver->user->profile['photo']
                ],

                'phones' => $driver->user->getPhonesWithLimit(5),

                'car_model' => $driver->car_model,

                'car_number' => $driver->car_number,

                'license' => $driver->license,

                'created_at' => $driver->created_at,

                'updated_at' => $driver->updated_at,
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

            'user' => [
                'full_name' => $driver->user->full_name,

                'email' => $driver->user->email
            ],

            'creator' => [
                'full_name' => $driver->creator->full_name,
            ],

            'partner' => [
                'id' => $driver->partner_id,

                'name' => $driver->partner->name,
            ],

            'phones' => $driver->user->getPhonesWithLimit(5),

            'car_model' => $driver->car_model,

            'car_number' => $driver->car_number,

            'license' => $driver->license,

            'created_at' => $driver->created_at,

            'updated_at' => $driver->updated_at,
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
            'address' => [
                'code' => $request->json('address.code'),

                'city_id' => $request->json('address.city_id'),

                'first_address' => $request->json('address.first_address'),

                'second_address' => $request->json('address.second_address')
            ],

            'user' => [
                'full_name' => $request->json('driver.full_name'),

                'email' => $request->json('driver.email')
            ],

            'phones' => collect($request->json('driver.phones'))->transform(function(string $phone) {
                return ['phone' => $phone];
            })->toArray(),

            'car' => [
                'partner_id' => $request->json('car.partner_id'),

                'car_model' => $request->json('car.car_model'),

                'car_number' => $request->json('car.car_number'),

                'license' => $request->json('car.license')
            ]
        ];
    }

    /**
     * @param DriversRequest $request
     *
     * @return array
     */
    public function updateCredentials(DriversRequest $request): array
    {
        return $this->storeCredentials($request);
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

    /**
     * @param Driver $driver
     * @param string $phone
     * @return array
     */
    public function showDriverPhone(Driver $driver, string $phone): array
    {
        return [
            'id' => $driver->id,

            'driver_full_name' => $driver->user->full_name,

            'driver_phone' => $driver->user->phones()->where('phone', '=', $phone)->first()->phone,

            'driver_email' => $driver->user->email,

            'driver_region' => $driver->user->addresses()->first()->city->region->name,

            'driver_city' => $driver->user->addresses()->first()->city->name,

            'driver_zip_code' => $driver->user->addresses()->first()->city->codes[0],

            'driver_address_line_1' => $driver->user->addresses()->first()->first_address,

            'driver_address_line_2' => $driver->user->addresses()->first()->second_address,

            'car_number' => $driver->car_number,

            'car_model' => $driver->car_model,

            'license' => $driver->license
        ];
    }

    /**
     * @param DriversRequest $request
     *
     * @return string
     */
    public function getOnlyPhone(DriversRequest $request): string
    {
        return $request->get('phone');
    }

    /**
     * @param Collection $drivers
     *
     * @return Collection
     */
    public function getPhones(Collection $drivers, string $phone): Collection
    {
        return $drivers->transform(function (Driver $driver) use($phone) {
            return [
                'id' => $driver->id,

                'full_name' => $driver->user->full_name,

                'phone' => $driver->getPhone($phone)
            ];
        });
    }
}
