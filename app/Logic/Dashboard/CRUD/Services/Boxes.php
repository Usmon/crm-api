<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Box;

use App\Logic\Dashboard\CRUD\Requests\Boxes as BoxesRequest;

use App\Models\BoxItem;

use App\Models\OrderHistory;

use Illuminate\Contracts\Pagination\Paginator;

use Illuminate\Support\Collection;

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

            'creator' => $request->json('creator'),

            'customer' => $request->json('customer'),
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
            'weight', 'additional_weight', 'status', 'creator', 'customer');
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

                'creator' => [
                    'id' => $box->creator->id,

                    'image' => $box->creator['profile']['photo'],

                    'name' => $box->creator->full_name,
                ],

                'customer' => [
                    'id' => $box->order->sender->id,

                    'image' => $box->order->sender->customer->user['profile']['photo'],

                    'name' => $box->order->sender->customer->user->full_name,
                ],

                'total_products' => $box->items()->count(),

                'total_price' => $box->items()->sum('price'),

                'total_weight' =>
                    $box->items()->where('type_weight', '=', 'lb')->sum('weight')
                    . 'lb ' .
                    $box->items()->where('type_weight', '=', 'kg')->sum('weight')
                    .'kg',

                'status' => $box->status->for_color,

                'created_at' => $box->created_at,

                'updated_at' => $box->updated_at,
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

            'total_products' => $box->total_products,

            'total_weight' => $box->weight,

            'total_price' => $box->total_price,

            'note' => $box->note,

            'created_at' => $box->created_at,

            'creator' => [
                'id' => $box->creator->id,

                'name' => $box->creator->full_name
            ],

            'products' => $box->items->transform(function (BoxItem  $product) {
                return [
                    'id' => $product->id,

                    'name' => $product->name,

                    'weight' => $product->weight,

                    'price' => $product->price
                ];
            }),

            'status' => $box->status->for_color,

            'history' => $box->histories->transform(function(OrderHistory $history, int $index) {
                return [
                    'seq' => ++$index,

                    'creator' => [
                        'id' => $history->creator_id,

                        'name' => $history->creator->full_name,
                    ],

                    'status' => $history->status->for_color,

                    'created_at' => $history->created_at
                ];
            })->reverse()->values(),
        ];
    }

    /**
     * @param Collection $boxes
     *
     * @return Collection
     */
    public function showBoxes(Collection $boxes): Collection
    {
        return $boxes->transform(function(Box $box) {
            return $this->showBox($box);
        });
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

            'weight' => array_sum(array_column($request->json('products'),'weight')),

            'additional_weight' => $request->json('additional_weight'),

            'delivery_id' => $request->json('delivery_id'),

            'shipment_id' => $request->json('shipment_id'),

            'note' => $request->json('note'),

            'products' => $request->json('products'),
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

            'weight' => array_sum(array_column($request->json('products'),'weight')),

            'additional_weight' => $request->json('additional_weight'),

            'delivery_id' => $request->json('delivery_id'),

            'shipment_id' => $request->json('shipment_id'),

            'note' => $request->json('note'),

            'products' => $request->json('products'),
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
