<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Pickup;

use Illuminate\Contracts\Pagination\Paginator;

final class Pickups
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getPickups(array $filters, array $sorts): Paginator
    {
        return Pickup::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $pickupData
     *
     * @return Pickup
     */
    public function storePickup (array $pickupData): Pickup
    {
        $pickup = new Pickup;

        $pickup->fill($pickupData);

        $pickup->save();

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

