<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\OrderComment;

use Illuminate\Contracts\Pagination\Paginator;

final class OrderComments
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getOrderComments(array $filters): Paginator
    {
        return OrderComment::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return OrderComment
     */
    public function storeOrderComment(array $credentials): OrderComment
    {
        $orderComment = OrderComment::create($credentials);

        return $orderComment;
    }

    /**
     * @param OrderComment $orderComment
     *
     * @param array $credentials
     *
     * @return OrderComment
     */
    public function updateOrderComment(OrderComment $orderComment, array $credentials): OrderComment
    {
        $orderComment->update($credentials);

        return $orderComment;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteOrderComment($id)
    {
        return OrderComment::destroy($id);
    }
}
