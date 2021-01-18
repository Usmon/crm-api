<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Product;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Products as ProductsRequest;

final class Products
{
    /**
     * @param ProductsRequest $request
     *
     * @return array
     */
    public function getAllFilters(ProductsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'order_id' => $request->json('order_id'),

            'name' => $request->json('name'),

            'status' => $request->json('status'),

            'quantity' => $request->json('quantity'),

            'price' => $request->json('price'),

            'weight' => $request->json('weight'),

            'type_weight' => $request->json('type_weight'),

            'note' => $request->json('note'),
        ];
    }

    /**
     * @param ProductsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(ProductsRequest $request): array
    {
        return $request->only('search', 'date', 'order_id', 'name',
            'status', 'quantity', 'price', 'weight', 'type_weight', 'note');
    }

    /**
     * @param ProductsRequest $request
     *
     * @return array
     */
    public function getAllSorts(ProductsRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param ProductsRequest $request
     *
     * @return array
     */
    public function getOnlySorts(ProductsRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getProducts(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Product $product) {
            return [
                'id' => $product->id,

                'order_id' => $product->order_id,

                'name' => $product->name,

                'status' => $product->status,

                'quantity' => $product->quantity,

                'price' => $product->price,

                'weight' => $product->weight,

                'type_weight' => $product->type_weight,

                'note' => $product->note,

                'created_at' => $product->created_at,

                'updated_at' => $product->updated_at,

                'order' => $product->order,
            ];
        });

        return $paginator;
    }

    /**
     * @param Product $product
     *
     * @return array
     */
    public function showProduct(Product $product): array
    {
        return [
            'id' => $product->id,

            'order_id' => $product->order_id,

            'name' => $product->name,

            'status' => $product->status,

            'quantity' => $product->quantity,

            'price' => $product->price,

            'weight' => $product->weight,

            'type_weight' => $product->type_weight,

            'note' => $product->note,

            'created_at' => $product->created_at,

            'updated_at' => $product->updated_at,

            'order' => $product->order,
        ];
    }

    /**
     * @param ProductsRequest $request
     *
     * @return array
     */
    public function storeCredentials(ProductsRequest $request): array
    {
        return [
            'order_id' => $request->json('order_id'),

            'name' => $request->json('name'),

            'status' => $request->json('status'),

            'quantity' => $request->json('quantity'),

            'price' => $request->json('price'),

            'weight' => $request->json('weight'),

            'type_weight' => $request->json('type_weight'),

            'note' => $request->json('note'),
        ];
    }

    /**
     * @param ProductsRequest $request
     *
     * @return array
     */
    public function updateCredentials(ProductsRequest $request): array
    {
        $credentials = [
            'order_id' => $request->json('order_id'),

            'name' => $request->json('name'),

            'status' => $request->json('status'),

            'quantity' => $request->json('quantity'),

            'price' => $request->json('price'),

            'weight' => $request->json('weight'),

            'type_weight' => $request->json('type_weight'),

            'note' => $request->json('note'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteProduct($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
