<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\DeliveryComment;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\DeliveryComments as DeliveryCommentsRequest;

final class DeliveryComments
{
    /**
     * @param DeliveryCommentsRequest $request
     *
     * @return array
     */
    public function getAllFilters(DeliveryCommentsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'delivery_id' => $request->json('delivery_id'),

            'comment' => $request->json('comment'),
        ];
    }

    /**
     * @param DeliveryCommentsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(DeliveryCommentsRequest $request): array
    {
        return $request->only('search', 'date', 'delivery_id', 'owner_id', 'comment');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getDeliveryComments(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (DeliveryComment $deliveryComment) {
            return [
                'id' => $deliveryComment->id,

                'delivery_id' => $deliveryComment->delivery_id,

                'owner_id' => $deliveryComment->owner_id,

                'comment' => $deliveryComment->comment,

                'created_at' => $deliveryComment->created_at,

                'updated_at' => $deliveryComment->updated_at,
            ];
        });
        return $paginator;
    }

    /**
     * @param DeliveryComment $deliveryComment
     *
     * @return array
     */
    public function showDeliveryComment(DeliveryComment $deliveryComment): array
    {
        return [
            'id' => $deliveryComment->id,

            'delivery_id' => $deliveryComment->delivery_id,

            'owner_id' => $deliveryComment->owner_id,

            'comment' => $deliveryComment->comment,

            'created_at' => $deliveryComment->created_at,

            'updated_at' => $deliveryComment->updated_at,
        ];
    }

    /**
     * @param DeliveryCommentsRequest $request
     *
     * @return array
     */
    public function storeCredentials(DeliveryCommentsRequest $request): array
    {
        return [
            'delivery_id' => $request->json('delivery_id'),

            'comment' => $request->json('comment')
        ];
    }

    /**
     * @param DeliveryCommentsRequest $request
     *
     * @return array
     */
    public function updateCredentials(DeliveryCommentsRequest $request): array
    {
        $credentials = [
            'delivery_id' => $request->json('delivery_id'),

            'comment' => $request->json('comment')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteDeliveryComment($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
