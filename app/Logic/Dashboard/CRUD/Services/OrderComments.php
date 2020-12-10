<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\OrderComment;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\OrderComments as OrderCommentsRequest;

final class OrderComments
{
    /**
     * @param OrderCommentsRequest $request
     *
     * @return array
     */
    public function getAllFilters(OrderCommentsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'order_id' => $request->json('order_id'),

            'owner_id' => $request->json('owner_id'),

            'comment' => $request->json('comment'),
        ];
    }

    /**
     * @param OrderCommentsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(OrderCommentsRequest $request): array
    {
        return $request->only('search', 'date', 'order_id', 'owner_id', 'comment');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getOrderComments(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (OrderComment $orderComment) {
            return [
                'id' => $orderComment->id,

                'order_id' => $orderComment->order_id,

                'owner_id' => $orderComment->owner_id,

                'comment' => $orderComment->comment,

                'updated_at' => $orderComment->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param OrderComment $orderComment
     *
     * @return array
     */
    public function showOrderComment(OrderComment $orderComment): array
    {
        return [
            'id' => $orderComment->id,

            'order_id' => $orderComment->order_id,

            'owner_id' => $orderComment->owner_id,

            'created_at' => $orderComment->created_at,

            'comment' => $orderComment->comment,

            'updated_at' => $orderComment->updated_at,
        ];
    }

    /**
     * @param OrderCommentsRequest $request
     *
     * @return array
     */
    public function storeCredentials(OrderCommentsRequest $request): array
    {
        return [
            'order_id' => $request->json('order_id'),

            'comment' => $request->json('comment')
        ];
    }

    /**
     * @param OrderCommentsRequest $request
     *
     * @return array
     */
    public function updateCredentials(OrderCommentsRequest $request): array
    {
        $credentials = [
            'order_id' => $request->json('order_id'),

            'comment' => $request->json('comment')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteOrderComment($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
