<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Box;

use App\Models\BoxItem;

use App\Models\Delivery;

use Illuminate\Contracts\Pagination\Paginator;

final class Deliveries
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getDeliveries(array $filters, array $sorts): Paginator
    {
        return Delivery::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $deliveryData
     *
     * @return Delivery
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function storeDelivery(array $deliveryData): Delivery
    {
        $delivery = new Delivery;

        $delivery->fill($deliveryData);

        $delivery->save();

        self::createBoxes($delivery->id, $deliveryData['boxes']);

        return $delivery;
    }

    /**
     * @param Delivery $delivery
     *
     * @param array $deliveryData
     *
     * @return Delivery
     */
    public function updateDelivery(Delivery $delivery, array $deliveryData): Delivery
    {
        $delivery->update($deliveryData);

        self::removeBoxes($delivery->id);

        self::createBoxes($delivery->id, $deliveryData['boxes']);

        return $delivery;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function deleteDelivery($id): bool
    {
        return Delivery::destroy($id);
    }

    /**
     * @param int $deliveryId
     *
     * @param array $boxes
     *
     * @return void
     */
    public function createBoxes(int $deliveryId, array $boxes): void
    {
        foreach ($boxes as $box)
        {
            $newBox = Box::create([
                'delivery_id' => $deliveryId,

                'note' => $box['note'],

                'status_id' => 3,

                'weight' => 0,
            ]);

            self::createProduct($newBox->id, $box['products']);

        }
    }

    /**
     * @param int $shipmentId
     *
     * @return void
     */
    public function removeBoxes(int $shipmentId): void
    {
        Box::where('delivery_id', '=', $shipmentId)->update([
            'delivery_id' => null,
        ]);
    }

    /**
     * @param int $boxId
     *
     * @param array $products
     *
     * @return void
     */
    public function createProduct(int $boxId, array $products): void
    {
        foreach ($products as $product)
        {
            $product['box_id'] = $boxId;

            BoxItem::create($product);
        }
    }
}
