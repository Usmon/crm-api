<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Driver;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

final class Drivers
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getDrivers(array $filters, array $sorts): Paginator
    {
        return Driver::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Driver
     */
    public function storeDriver(array $credentials): Driver
    {
        //Create user
        $user = User::factory()->create($credentials['user']);

        //Binding Driver
        $user->driver()->create($credentials['car']);

        //Binding address
        $user->addresses()->create($credentials['address']);

        //Create phone for user
        $user->phones()->createMany($credentials['phones']);

        return $user->driver;
    }

    /**
     * @param Driver $driver
     *
     * @param array $credentials
     *
     * @return Driver
     */
    public function updateDriver(Driver $driver, array $credentials): Driver
    {
        $driver->user->update($credentials['user']);

        $driver->user->addresses()->delete();

        $driver->user->phones()->delete();

        $driver->user->phones()->createMany($credentials['phones']);

        $driver->user->addresses()->create($credentials['address']);

        $driver->update($credentials['car']);

        return $driver->refresh();
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteDriver($id)
    {
        return Driver::destroy($id);
    }

    /**
     * @param string $phone
     *
     * @return Driver
     */
    public function checkPhone(string $phone): Driver
    {
        return Driver::filterPhone($phone)->first();
    }

    /**
     * @param string $phone
     *
     * @return Collection
     */
    public function searchByPhone(string $phone): Collection
    {
        return Driver::filterPhone($phone)->get();
    }
}
