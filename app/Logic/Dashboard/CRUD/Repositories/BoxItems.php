<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use Exception;

use App\Models\BoxItem;

use Illuminate\Support\Arr;

use Illuminate\Contracts\Pagination\Paginator;

final class BoxItems
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getBoxItems(array $filters): Paginator
    {
        return BoxItem::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $boxData
     *
     * @return BoxItem
     */
    public function storeBoxItem(array $boxData): BoxItem
    {
        $boxItem = new BoxItem;

        $boxItem->fill($boxData);

        $boxItem->save();

        return $boxItem;
    }

    /**
     * @param BoxItem $boxItem
     *
     * @param array $boxData
     *
     * @return BoxItem
     */
    public function updateBoxItem(BoxItem $boxItem, array $boxData)
    {
        $boxItem->update($boxData);

        return $boxItem;
    }

    /**
     * @param BoxItem $boxItem
     *
     * @return bool
     */
    public function deleteBoxItem($id): bool
    {
        return BoxItem::destroy($id);
    }
}
