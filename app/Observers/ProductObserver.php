<?php

namespace App\Observers;

use App\Models\Product;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class ProductObserver
{
    /**
     * @param Product $product
     *
     * @return void
     */
    public function creating(Product $product): void
    {
        $this->defaultProperties($product);
    }

    /**
     * @param Product $product
     *
     * @return void
     */
    public function updating(Product $product): void
    {
        $this->defaultProperties($product);
    }

    /**
     * @param Product $product
     *
     * @return void
     */
    public function deleting(Product $product): void
    {
        $product->deleted_by = $product->deleted_by ?? Auth::id();

        $product->deleted_at = $product->deleted_at ?? Carbon::now();

        $product->status = $product->status ?? 'created';

        $product->update();
    }

    /**
     * @param Product $product
     *
     * @return void
     */
    public function restoring(Product $product): void
    {
        $product->deleted_at = null;
    }

    /**
     * @param Product $product
     *
     * @return void
     */
    protected function defaultProperties(Product $product): void
    {
        $product->created_at = $product->created_at ?? Carbon::now();

        $product->updated_at = $product->updated_at ?? Carbon::now();

        $product->deleted_at = $product->deleted_at ?? null;
    }
}
