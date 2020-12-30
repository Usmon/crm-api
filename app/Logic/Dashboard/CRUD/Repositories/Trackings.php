<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Tracking;

use Illuminate\Contracts\Pagination\Paginator;

final class Trackings
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getTrackings(array $filters, array $sorts): Paginator
    {
        return Tracking::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Tracking
     */
    public function storeTracking(array $credentials): Tracking
    {
        $tracking = Tracking::create($credentials);

        return $tracking;
    }


    /**
     * @param Tracking $tracking
     *
     * @param array $credentials
     *
     * @return Tracking
     */
    public function updateTracking(Tracking $tracking, array $credentials): Tracking
    {
        $tracking->update($credentials);

        return $tracking;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteTracking($id)
    {
        return Tracking::destroy($id);
    }
}
