<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Pickup;

use App\Logic\Dashboard\CRUD\Requests\Pickups as PickupsRequest;

use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Hash;

use Illuminate\Contracts\Pagination\Paginator;

final class Pickups
{
    /**
     * @param PickupsRequest $request
     *
     * @return array
     */
    public function getAllFilters(PickupsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),
        ];
    }

    /**
     * @param PickupsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(PickupsRequest $request): array
    {
        return $request->only('search', 'date');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getPickups(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Pickup $pickup) {
            return [
                'id' => $pickup->id,

                'note' => $pickup->note,

                'bring_adress' => $pickup->bring_address,

                'bring_datetime_start' => $pickup->bring_datetime_start,

                'bring_datetime_end' => $pickup->bring_datetime_end,

                'staff_id' => $pickup->staff_id,

                'customer_id' => $pickup->customer_id,

                'driver_id' => $pickup->driver_id,

                'created_at' => $pickup->created_at,

                'updated_at' => $pickup->updated_at,
            ];
        });

        return $paginator;


    }



    /**
     * @param Pickup $pickup
     *
     * @return array
     */
    public function showPickup(Pickup $pickup): array
    {
        return [
            'id' => $pickup->id,

            'note' => $pickup->note,

            'bring_adress' => $pickup->bring_address,

            'bring_datetime_start' => $pickup->bring_datetime_start,

            'bring_datetime_end' => $pickup->bring_datetime_end,

            'staff_id' => $pickup->staff_id,

            'driver_id' => $pickup->driver_id,

            'customer_id' => $pickup->customer_id,

            'created_at' => $pickup->created_at,

            'updated_at' => $pickup->updated_at,
        ];
    }

    /**
     * @param PickupsRequest $request
     *
     * @return array
     */
    public function createPickup(PickupsRequest $request): array
    {
        return [
            'note' => $request->json('note'),

            'bring_address' => $request->json('bring_address'),

            'bring_datetime_start' => $request->json('bring_datetime_start'),

            'bring_datetime_end' => $request->json('bring_datetime_end'),

            'staff_id' => $request->json('staff_id'),

            'driver_id' => $request->json('driver_id'),

            'customer_id' => $request->json('customer_id'),
        ];
    }

    /**
     * @param PickupsRequest $request
     *
     * @return array
     */
    public function updatePickup(PickupsRequest $request): array
    {
        $pickups = [
            'note' => $request->json('note'),

            'bring_adress' => $request->json('bring_address'),

            'bring_datetime_start' => $request->json('bring_datetime_start'),

            'bring_datetime_end' => $request->json('bring_datetime_end'),

            'staff_id' => $request->json('staff_id'),

            'driver_id' => $request->json('driver_id'),

            'customer_id' => $request->json('customer_id'),
        ];

        return $pickups;
    }

    public function deletePickup($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }


}
