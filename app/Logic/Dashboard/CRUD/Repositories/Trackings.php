<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Tracking;

use Illuminate\Contracts\Pagination\Paginator;

final class Trackings
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getTrackings(array $filters): Paginator
    {
        return Tracking::filter($filters)->orderBy('created_at', 'desc')->pager();
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
