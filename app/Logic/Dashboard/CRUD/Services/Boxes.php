<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Box;

use App\Logic\Dashboard\CRUD\Requests\Boxes as BoxesRequest;

use Illuminate\Support\Arr;

use Illuminate\Contracts\Pagination\Paginator;

final class Boxes
{
    /**
     * @param BoxesRequest $request
     *
     * @return array
     */
    public function getAllFilters(BoxesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'order_id' => $request->json('order_id'),

            'customer_id' => $request->json('customer_id'),

            'sender_id' => $request->json('sender_id'),

            'recipient_id' => $request->json('recipient_id'),

            'status' => $request->json('status'),

            'weight' => $request->json('weight'),

            'additional_weight' => $request->json('additional_weight'),

            'order' => $request->json('order'),

            'customer' => $request->json('customer'),

            'sender' => $request->json('sender'),

            'recipient' => $request->json('recipient'),
        ];
    }

    /**
     * @param BoxesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(BoxesRequest $request): array
    {
        return $request->only('search', 'date','order_id','customer_id','sender_id',
        'recipient_id','status', 'weight', 'additional_weight','order','customer','sender','recipient' );
    }

    /**
     * @param BoxesRequest $request
     *
     * @return array
     */
    public function getAllSorts(BoxesRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param BoxesRequest $request
     *
     * @return array
     */
    public function getOnlySorts(BoxesRequest $request): array
    {
        return $request->only('sort');
    }


    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getBoxes(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform( function (Box $box) {
            return [
                'id' => $box->id,

                'order_id' => $box->order_id,

                'customer_id' => $box->customer_id,

                'sender_id' => $box->sender_id,

                'recipient_id' => $box->recipient_id,

                'weight' => $box->weight,

                'additional_weight' => $box->additional_weight,

                'status' => $box->status,

                'box_image' => $box->box_image,

                'created_at' => $box->created_at,

                'updated_at' => $box->updated_at,

                'order' => $box->order,

                'customer' => $box->customer,

                'sender' => $box->sender,

                'recipient' => $box->recipient,
            ];
        });

        return $paginator;
    }

    /**
     * @param Box $box
     *
     * @return array
     */
    public function showBox(Box $box): array
    {
        return [
            'id' => $box->id,

            'order_id' => $box->order_id,

            'customer_id' => $box->customer_id,

            'sender_id' => $box->sender_id,

            'recipient_id' => $box->recipient_id,

            'weight' => $box->weight,

            'additional_weight' => $box->additional_weight,

            'status' => $box->status,

            'box_image' => $box->box_image,

            'created_at' => $box->created_at,

            'updated_at' => $box->updated_at,

            'order' => $box->order,

            'customer' => $box->customer,

            'sender' => $box->sender,

            'recipient' => $box->recipient,

        ];
    }

    /**
     * @param BoxesRequest $request
     *
     * @return array
     */
    public function createBox(BoxesRequest $request): array
    {
        return [
            'order_id' => $request->json('order_id'),

            'customer_id' => $request->json('customer_id'),

            'sender_id' => $request->json('sender_id'),

            'recipient_id' => $request->json('recipient_id'),

            'weight' => $request->json('weight'),

            'additional_weight' => $request->json('additional_weight'),

            'status' => $request->json('status'),

            'box_image' => $request->json('box_image'),
        ];
    }

    /**
     * @param BoxesRequest $request
     *
     * @return array
     */
    public function updateBox(BoxesRequest $request): array
    {
        $boxes = [
            'order_id' => $request->json('order_id'),

            'customer_id' => $request->json('customer_id'),

            'sender_id' => $request->json('sender_id'),

            'recipient_id' => $request->json('recipient_id'),

            'weight' => $request->json('weight'),

            'additional_weight' => $request->json('additional_weight'),

            'status' => $request->json('status'),

            'box_image' => $request->json('box_image'),
        ];

        return $boxes;
    }

    /**
     * @param $id
     */
    public function deleteBox($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int') === $id) ? $id : 0;
    }
}
