<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\City;

use Illuminate\Contracts\Pagination\Paginator;

final class Cities
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getCities(array $filters, array $sorts): Paginator
    {
        return City::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return City
     */
    public function storeCity(array $credentials): City
    {
        $city = City::create($credentials);

        return $city;
    }

    /**
     * @param City $city
     *
     * @param array $credentials
     *
     * @return City
     */
    public function updateCity(City $city, array $credentials): City
    {
        $city->update($credentials);

        return $city;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteCity($id)
    {
        return City::destroy($id);
    }
}
