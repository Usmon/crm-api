<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Box;

use App\Models\Pickup;

use App\Models\BoxItem;

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
     * @param array $credentials
     *
     * @return Pickup
     */
    public function storePickup (array $credentials): Pickup
    {

//        $sumPriceProducts = array_sum(
//            array_column(
//                call_user_func_array('array_merge',
//                    array_values(array_column($credentials['boxes'],
//                        'products'))),
//                'price'));

        $pickup = Pickup::create($credentials);

        if($credentials['boxes'])
        {
            $this->createBoxes($pickup, $credentials['boxes']);
        }

        return $pickup;
    }

    /**
     * @param Pickup $pickup
     *
     * @param array $pickupData
     *
     * @return Pickup
     */
    public function updatePickup(Pickup $pickup, array $pickupData): Pickup
    {
        $pickup->update($pickupData);

        return $pickup;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function deletePickup($id): bool
    {
        return Pickup::destroy($id);
    }

    /**
     * @param Pickup $pickup
     *
     * @param array $boxes
     */
    public function createBoxes(Pickup $pickup, array $boxes): void
    {
        foreach ($boxes as $box)
        {

            $newBox = Box::create([
                'pickup_id' => $pickup->id,

                'note' => $box['note'],

                'status_id' => 3,

                'weight' => array_sum(array_column($box['products'],'weight')),

                'additional_weight' => array_sum(array_column($box['products'],'is_additional')),
            ]);

            foreach ($box['products'] as $product)
            {
                $product['box_id'] = $newBox->id;

                $newProduct = BoxItem::create($product);
            }
        }
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function updateShow(int $id)
    {
        return Pickup::findOrFail($id);
    }
}

