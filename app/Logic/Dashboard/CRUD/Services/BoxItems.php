<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\BoxItem;

use App\Logic\Dashboard\CRUD\Requests\BoxItems as BoxItemsRequest;

use Illuminate\Support\Arr;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

final class BoxItems
{
    /**
     * @param BoxItemsRequest $request
     *
     * @return array
     */
    public function getAllFilters(BoxItemsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'quantity' => $request->json('quantity'),

            'weight' => $request->json('weight'),

            'price' => $request->json('price'),
        ];
    }

    /**
     * @param BoxItemsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(BoxItemsRequest $request): array
    {
        return $request->only('search', 'date', 'quantity', 'weight', 'price');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getBoxItems(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform( function (BoxItem $boxItem) {
            return [
                'id' => $boxItem->id,

                'box_id' => $boxItem->box_id,

                'name' => $boxItem->name,

                'quantity' => $boxItem->quantity,

                'price' => $boxItem->price,

                'weight' => $boxItem->weight,

                'made_in' => $boxItem->made_in,

                'note' => $boxItem->note,

                'is_additional' => $boxItem->is_additional,

                'image' => $boxItem->image,

                'created_at' => $boxItem->created_at,

                'updated_at' => $boxItem->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param BoxItem $boxItem
     *
     * @return array
     */
    public function showBoxItem(BoxItem $item): array
    {
        return [
            'id' => $item->id,

            'box_id' => $item->box_id,

            'name' => $item->name,

            'quantity' => $item->quantity,

            'price' => $item->price,

            'weight' => $item->weight,

            'made_in' => $item->made_in,

            'note' => $item->note,

            'is_additional' => $item->is_additional,

            'image' => $item->image,

            'created_at' => $item->created_at,

            'updated_at' => $item->updated_at,
        ];
    }

    /**
     * @param Collection $products
     *
     * @return Collection
     */
    public function getProducts(Collection $products): Collection
    {
        return $products->transform(function(BoxItem $product) {
            return $this->showBoxItem($product);
        });
    }

    /**
     * @param BoxItemsRequest $request
     *
     * @return array
     */
    public function createBoxItem(BoxItemsRequest $request): array
    {
        return [
            'box_id' => $request->json('box_id'),

            'name' => $request->json('name'),

            'quantity' => $request->json('quantity'),

            'price' => $request->json('price'),

            'weight' => $request->json('weight'),

            'made_in' => $request->json('made_in'),

            'note' => $request->json('note'),

            'is_additional' => $request->json('is_additional'),
        ];
    }

    /**
     * @param BoxItemsRequest $request
     *
     * @return array
     */
    public function updateBoxItem(BoxItemsRequest $request): array
    {
        $boxItems = [
            'box_id' => $request->json('box_id'),

            'warehouse_item_id' => $request->json('warehouse_item_id'),

            'name' => $request->json('name'),

            'quantity' => $request->json('quantity'),

            'price' => $request->json('price'),

            'weight' => $request->json('weight'),

            'made_in' => $request->json('made_in'),

            'note' => $request->json('note'),

            'is_additional' => $request->json('is_additional'),
        ];

        return $boxItems;
    }

    /**
     * @param $id
     */
    public function deleteBoxItem($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int') === $id) ? $id : 0;
    }
}
