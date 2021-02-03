<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Driver;

use Illuminate\Contracts\Pagination\Paginator;

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
        $driver = Driver::create($credentials);

        return $driver;
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
        $driver->update($credentials);

        return $driver;
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
}
