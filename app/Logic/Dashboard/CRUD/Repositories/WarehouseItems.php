<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\WarehouseItem;

use Illuminate\Contracts\Pagination\Paginator;

final class WarehouseItems
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getWarehouseItems(array $filters): Paginator
    {
        return WarehouseItem::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return WarehouseItem
     */
    public function storeWarehouseItem(array $credentials): WarehouseItem
    {
        $warehouseItem = WarehouseItem::create($credentials);

        return $warehouseItem;
    }

    /**
     * @param WarehouseItem $warehouseItem
     *
     * @param array $credentials
     *
     * @return WarehouseItem
     */
    public function updateWarehouseItem(WarehouseItem $warehouseItem, array $credentials): WarehouseItem
    {
        $warehouseItem->update($credentials);

        return $warehouseItem;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteWarehouseItem($id)
    {
        return WarehouseItem::destroy($id);
    }
}
