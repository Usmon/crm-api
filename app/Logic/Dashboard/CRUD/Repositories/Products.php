<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Product;

use Illuminate\Contracts\Pagination\Paginator;

final class Products
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getProducts(array $filters, array $sorts): Paginator
    {
        return Product::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Product
     */
    public function storeProduct(array $credentials): Product
    {
        $product = Product::create($credentials);

        return $product;
    }


    /**
     * @param Product $product
     *
     * @param array $credentials
     *
     * @return Product
     */
    public function updateProduct(Product $product, array $credentials): Product
    {
        $product->update($credentials);

        return $product;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteProduct($id)
    {
        return Product::destroy($id);
    }
}
