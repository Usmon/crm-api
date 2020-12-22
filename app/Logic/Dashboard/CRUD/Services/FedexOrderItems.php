<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\FedexOrderItem;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\FedexOrderItem as FedexOrderItemsRequest;

final class FedexOrderItems
{
    /**
     * @param FedexOrderItemsRequest $request
     *
     * @return array
     */
    public function getAllFilters(FedexOrderItemsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'fedex_order_id' => $request->json('fedex_order_id'),

            'weight' => $request->json('weight'),

            'width' => $request->json('width'),

            'height' => $request->json('height'),

            'length' => $request->json('length'),

            'service_price' => $request->json('service_price'),

            'label_file_name' => $request->json('label_file_name'),

            'barcode' => $request->json('barcode'),
        ];
    }

    /**
     * @param FedexOrderItemsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(FedexOrderItemsRequest $request): array
    {
        return $request->only('search', 'date', 'fedex_order_id', 'weight',
            'width', 'height', 'length', 'service_price', 'label_file_name', 'barcode');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getFedexOrderItems(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (FedexOrderItem $fedexOrderItem) {
            return [
                'id' => $fedexOrderItem->id,

                'fedex_order_id' => $fedexOrderItem->fedex_order_id,

                'weight' => $fedexOrderItem->weight,

                'width' => $fedexOrderItem->width,

                'height' => $fedexOrderItem->height,

                'length' => $fedexOrderItem->length,

                'service_price' => $fedexOrderItem->service_price,

                'label_file_name' => $fedexOrderItem->label_file_name,

                'barcode' => $fedexOrderItem->barcode,

                'created_at' => $fedexOrderItem->created_at,

                'updated_at' => $fedexOrderItem->updated_at,

                'fedex_order' => $fedexOrderItem->fedex_order,
            ];
        });

        return $paginator;
    }

    /**
     * @param FedexOrderItem $fedexOrderItem
     *
     * @return array
     */
    public function showFedexOrderItem(FedexOrderItem $fedexOrderItem): array
    {
        return [
            'id' => $fedexOrderItem->id,

            'fedex_order_id' => $fedexOrderItem->fedex_order_id,

            'weight' => $fedexOrderItem->weight,

            'width' => $fedexOrderItem->width,

            'height' => $fedexOrderItem->height,

            'length' => $fedexOrderItem->length,

            'service_price' => $fedexOrderItem->service_price,

            'label_file_name' => $fedexOrderItem->label_file_name,

            'barcode' => $fedexOrderItem->barcode,

            'created_at' => $fedexOrderItem->created_at,

            'updated_at' => $fedexOrderItem->updated_at,

            'fedex_order' => $fedexOrderItem->fedex_order,
        ];
    }

    /**
     * @param FedexOrderItemsRequest $request
     *
     * @return array
     */
    public function storeCredentials(FedexOrderItemsRequest $request): array
    {
        return [
            'fedex_order_id' => $request->json('fedex_order_id'),

            'weight' => $request->json('weight'),

            'width' => $request->json('width'),

            'height' => $request->json('height'),

            'length' => $request->json('length'),

            'service_price' => $request->json('service_price'),

            'label_file_name' => $request->json('label_file_name'),

            'barcode' => $request->json('barcode'),
        ];
    }

    /**
     * @param FedexOrderItemsRequest $request
     *
     * @return array
     */
    public function updateCredentials(FedexOrderItemsRequest $request): array
    {
        $credentials = [
            'fedex_order_id' => $request->json('fedex_order_id'),

            'weight' => $request->json('weight'),

            'width' => $request->json('width'),

            'height' => $request->json('height'),

            'length' => $request->json('length'),

            'service_price' => $request->json('service_price'),

            'label_file_name' => $request->json('label_file_name'),

            'barcode' => $request->json('barcode'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteFedexOrderItem($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
