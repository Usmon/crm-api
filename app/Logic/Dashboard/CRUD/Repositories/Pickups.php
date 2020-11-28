<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use Exception;

use App\Models\Pickup;

use Illuminate\Support\Arr;

use Illuminate\Database\Eloquent\Collection;

final class Pickups
{
    /**
     * @param array $filters
     *
     * @return Collection
     */
    public function getPickups(array $filters): Collection
    {
        return Pickup::filter($filters)->orderBy('created_at', 'desc')->get();
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
    public function deletePickup(Pickup $pickup): bool
    {
        try
        {
            $pickup->delete();
        }
        catch (Exception $e)
        {
            return false;
        }

        return true;
    }
}

