<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\DeliveryComment;

use Illuminate\Contracts\Pagination\Paginator;

final class DeliveryComments
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getDeliveryComments(array $filters): Paginator
    {
        return DeliveryComment::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return DeliveryComment
     */
    public function storeDeliveryComment(array $credentials): DeliveryComment
    {
        $deliveryComment = DeliveryComment::create($credentials);

        return $deliveryComment;
    }

    /**
     * @param DeliveryComment $deliveryComment
     *
     * @param array $credentials
     *
     * @return DeliveryComment
     */
    public function updateDeliveryComment(DeliveryComment $deliveryComment, array $credentials): DeliveryComment
    {
        $deliveryComment->update($credentials);

        return $deliveryComment;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteDeliveryComment($id)
    {
        return DeliveryComment::destroy($id);
    }
}
