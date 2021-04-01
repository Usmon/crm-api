<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Region;

use Illuminate\Database\Eloquent\Collection;

final class Regions
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Collection
     */
    public function getRegions(array $filters, array $sorts): Collection
    {
        return Region::filter($filters)->sort($sorts)->get();
    }

    /**
     * @param array $credentials
     *
     * @return Region
     */
    public function storeRegion(array $credentials): Region
    {
        return Region::create($credentials);
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
    public function deleteRegion($id): int
    {
        return Region::destroy($id);
    }

}
