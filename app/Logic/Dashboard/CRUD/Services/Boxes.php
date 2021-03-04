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

            'pickup_id' => $request->json('pickup_id'),

            'status_id' => $request->json('status_id'),

            'weight' => $request->json('weight'),

            'additional_weight' => $request->json('additional_weight'),

            'status' => $request->json('status'),
        ];
    }

    /**
     * @param BoxesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(BoxesRequest $request): array
    {
        return $request->only('search', 'date', 'pickup_id', 'status_id',
            'weight', 'additional_weight', 'status');
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

                'pickup_id' => $box->pickup_id,

                'order_id' => $box->order_id,

                'status_id' => $box->status_id,

                'weight' => $box->weight,

                'additional_weight' => $box->additional_weight,

                'box_image' => $box->box_image,

                'delivery_id' => $box->delivery_id,

                'created_at' => $box->created_at,

                'updated_at' => $box->updated_at,

                'pickup' => $box->pickup,

                'status' => $box->status,

                'delivery' => $box->delivery,

                'order' => $box->order
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

            'pickup_id' => $box->pickup_id,

            'order_id' => $box->order_id,

            'status_id' => $box->status_id,

            'weight' => $box->weight,

            'additional_weight' => $box->additional_weight,

            'box_image' => $box->box_image,

            'delivery_id' => $box->delivery_id,

            'created_at' => $box->created_at,

            'updated_at' => $box->updated_at,

            'pickup' => $box->pickup,

            'status' => $box->status,

            'delivery' => $box->delivery,

            'order' => $box->order
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
            'pickup_id' => $request->json('pickup_id'),

            'order_id' => $request->json('order_id'),

            'status_id' => $request->json('status_id'),

            'weight' => $request->json('weight'),

            'additional_weight' => $request->json('additional_weight'),

            'box_image' => $request->json('box_image'),

            'delivery_id' => $request->json('delivery_id'),
        ];
    }

    /**
     * @param BoxesRequest $request
     *
     * @return array
     */
    public function updateBox(BoxesRequest $request): array
    {
        return [
            'pickup_id' => $request->json('pickup_id'),

            'order_id' => $request->json('order_id'),

            'status_id' => $request->json('status_id'),

            'weight' => $request->json('weight'),

            'additional_weight' => $request->json('additional_weight'),

            'box_image' => $request->json('box_image'),

            'delivery_id' => $request->json('delivery_id'),
        ];
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
