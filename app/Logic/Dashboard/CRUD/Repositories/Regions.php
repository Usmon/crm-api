<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Region;

use Illuminate\Contracts\Pagination\Paginator;

final class Regions
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getRegions(array $filters, array $sorts): Paginator
    {
        return Region::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Region
     */
    public function storeRegion(array $credentials): Region
    {
        $region = Region::create($credentials);

        return $region;
    }

    /**
     * @param Region $region
     *
     * @param array $credentials
     *
     * @return Region
     */
    public function updateRegion(Region $region, array $credentials): Region
    {
        $region->update($credentials);

        return $region;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteRegion($id)
    {
        return Region::destroy($id);
    }

}
