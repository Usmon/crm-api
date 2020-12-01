<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use Exception;

use App\Models\Pickup;

use Illuminate\Support\Arr;

use Illuminate\Contracts\Pagination\Paginator;

final class Pickups
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getPickups(array $filters): Paginator
    {
        return Pickup::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $pickupData
     *
     * @return Pickup
     */
    public function storePickup (array $pickupData): Pickup
    {
        $pickup = Pickup::create($pickupData);

        return $pickup;
    }

    /**
     * @param Pickup $pickup
     *
     * @param array $pickupData
     *
     * @return Pickup
     */
    public function updatePickup(Pickup $pickup, array $pickupData)
    {
        $pickup->update($pickupData);

        return $pickup;
    }

    /**
     * @param Pickup $pickup
     *
     * @return bool
     */
    public function deletePickup($id): bool
    {
        return Pickup::destroy($id);
    }
}

