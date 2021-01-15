<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use Exception;

use App\Models\Box;

use Illuminate\Support\Arr;

use Illuminate\Contracts\Pagination\Paginator;

final class Boxes
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getBoxes(array $filters, array $sorts): Paginator
    {
        return Box::filter($filters)->sort($sorts)->pager();
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
    public function updateBox(Box $box, array $boxData)
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
