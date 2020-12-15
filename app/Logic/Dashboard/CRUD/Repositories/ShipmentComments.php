<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\ShipmentComment;

use Illuminate\Contracts\Pagination\Paginator;

final class ShipmentComments
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getShipmentComments(array $filters): Paginator
    {
        return ShipmentComment::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return ShipmentComment
     */
    public function storeShipmentComment(array $credentials): ShipmentComment
    {
        $task = ShipmentComment::create($credentials);

        return $task;
    }

    /**
     * @param ShipmentComment $shipmentComment
     *
     * @param array $credentials
     *
     * @return ShipmentComment
     */
    public function updateShipmentComment(ShipmentComment $shipmentComment, array $credentials): ShipmentComment
    {
        $shipmentComment->update($credentials);

        return $shipmentComment;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteShipmentComment($id)
    {
        return ShipmentComment::destroy($id);
    }
}
