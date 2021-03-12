<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Box;

use Illuminate\Contracts\Pagination\Paginator;

use Illuminate\Support\Collection;

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

        return $box;
    }

    /**
     * @param Box $box
     *
     * @return bool
     */
    public function deleteBox($id): bool
    {
        return Box::destroy($id);
    }
}
