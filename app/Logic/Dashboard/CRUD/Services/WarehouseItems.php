<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Logic\Dashboard\CRUD\Requests\WarehouseItems as WarehouseItemsRequest;

use App\Models\WarehouseItem;

use Illuminate\Contracts\Pagination\Paginator;

final class WarehouseItems
{
    /**
     * @param WarehouseItemsRequest $request
     *
     * @return array
     */
    public function getAllFilters(WarehouseItemsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'customer_id' => $request->json('customer_id'),

            'shipment_id' => $request->json('shipment_id'),

            'name' => $request->json('name'),

            'init_quantity' => $request->json('init_quantity'),

            'quantity' => $request->json('quantity'),

            'init_weight' => $request->json('init_weight'),

            'weight' => $request->json('weight'),

            'total_price' => $request->json('total_price'),

            'payed' => $request->json('payed'),

            'note' => $request->json('note')
        ];
    }

    /**
     * @param WarehouseItemsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(WarehouseItemsRequest $request): array
    {
        return $request->only('search', 'date', 'customer_id', 'shipment_id', 'name',
            'init_quantity', 'quantity', 'init_weight','weight','total_price','payed', 'note');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getWarehouseItems(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (WarehouseItem $warehouseItem) {
            return [
                'id' => $warehouseItem->id,

                'customer_id' => $warehouseItem->customer_id,

                'shipment_id' => $warehouseItem->shipment_id,

                'name' => $warehouseItem->name,

                'init_quantity' => $warehouseItem->init_quantity,

                'quantity' => $warehouseItem->quantity,

                'init_weight' => $warehouseItem->init_weight,

                'weight' => $warehouseItem->weight,

                'total_price' => $warehouseItem->total_price,

                'payed' => $warehouseItem->payed,

                'note' => $warehouseItem->note,

                'created_at' => $warehouseItem->created_at,

                'updated_at' => $warehouseItem->updated_at,

                'customer' => $warehouseItem->customer,

                'shipment' => $warehouseItem->shipment,
            ];
        });
        return $paginator;
    }

    /**
     * @param WarehouseItem $warehouseItem
     *
     * @return array
     */
    public function showWarehouseItem(WarehouseItem $warehouseItem): array
    {
        return [
            'id' => $warehouseItem->id,

            'customer_id' => $warehouseItem->customer_id,

            'shipment_id' => $warehouseItem->shipment_id,

            'name' => $warehouseItem->name,

            'init_quantity' => $warehouseItem->init_quantity,

            'quantity' => $warehouseItem->quantity,

            'init_weight' => $warehouseItem->init_weight,

            'weight' => $warehouseItem->weight,

            'total_price' => $warehouseItem->total_price,

            'payed' => $warehouseItem->payed,

            'note' => $warehouseItem->note,

            'created_at' => $warehouseItem->created_at,

            'updated_at' => $warehouseItem->updated_at,

            'customer' => $warehouseItem->customer,

            'shipment' => $warehouseItem->shipment,
        ];
    }

    /**
     * @param WarehouseItemsRequest $request
     *
     * @return array
     */
    public function storeCredentials(WarehouseItemsRequest $request): array
    {
        return [
            'customer_id' => $request->json('customer_id'),

            'shipment_id' => $request->json('shipment_id'),

            'name' => $request->json('name'),

            'init_quantity' => $request->json('init_quantity'),

            'quantity' => $request->json('quantity'),

            'init_weight' => $request->json('init_weight'),

            'weight' => $request->json('weight'),

            'total_price' => $request->json('total_price'),

            'payed' => $request->json('payed'),

            'note' => $request->json('note')
        ];
    }

    /**
     * @param WarehouseItemsRequest $request
     *
     * @return array
     */
    public function updateCredentials(WarehouseItemsRequest $request): array
    {
        $credentials = [
            'customer_id' => $request->json('customer_id'),

            'shipment_id' => $request->json('shipment_id'),

            'name' => $request->json('name'),

            'init_quantity' => $request->json('init_quantity'),

            'quantity' => $request->json('quantity'),

            'init_weight' => $request->json('init_weight'),

            'weight' => $request->json('weight'),

            'total_price' => $request->json('total_price'),

            'payed' => $request->json('payed'),

            'note' => $request->json('note')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteWarehouseItem($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
