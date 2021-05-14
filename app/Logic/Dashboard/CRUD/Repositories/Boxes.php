<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Box;

use App\Models\BoxItem;

use Illuminate\Support\Collection;

use Illuminate\Contracts\Pagination\Paginator;

final class Boxes
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getBoxes(array $filters, array $sorts): Paginator
    {
        return Box::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param int $order_id
     *
     * @return Collection
     */
    public function getBoxesByOrder(int $order_id): Collection
    {
        return Box::where('order_id', $order_id)->get();
    }

    /**
     * @param array $boxData
     *
     * @return Box
     */
    public function storeBox(array $boxData): Box
    {
        $box = new Box;

        $box->fill($boxData);

        $box->save();

        $this->createProducts($box->id, $boxData['products']);

        return $box;
    }

    /**
     * @param Box $box
     *
     * @param array $boxData
     *
     * @return Box
     */
    public function updateBox(Box $box, array $boxData): Box
    {
        $box->update($boxData);


        $this->deleteProducts($box->id);

        $this->createProducts($box->id, $boxData['products']);

        return $box;
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function deleteBox($id): bool
    {
        return Box::destroy($id);
    }

    /**
     * @param int $boxId
     *
     * @param array $products
     */
    public function createProducts(int $boxId, array $products)
    {
        foreach ($products as $product)
        {
            $product['box_id'] = $boxId;

            BoxItem::create($product);
        }
    }

    /**
     * @param int $boxId
     */
    public function deleteProducts(int $boxId)
    {
        BoxItem::where('box_id', '=', $boxId)->delete();
    }

    public function getShipments(int $id)
    {
        return Box::where('shipment_id', '=', $id)->pager();
    }
}
