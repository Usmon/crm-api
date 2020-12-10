<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\FedexOrderItem;

use Illuminate\Contracts\Pagination\Paginator;

final class FedexOrderItems
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getFedexOrderItems(array $filters): Paginator
    {
        return FedexOrderItem::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return FedexOrderItem
     */
    public function storeFedexOrderItem(array $credentials): FedexOrderItem
    {
        $fedexOrderItem = FedexOrderItem::create($credentials);

        return $fedexOrderItem;
    }

    /**
     * @param FedexOrderItem $fedexOrderItem
     *
     * @param array $credentials
     *
     * @return FedexOrderItem
     */
    public function updateFedexOrderItem(FedexOrderItem $fedexOrderItem, array $credentials): FedexOrderItem
    {
        $fedexOrderItem->update($credentials);

        return $fedexOrderItem;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteFedexOrderItem($id)
    {
        return FedexOrderItem::destroy($id);
    }
}
