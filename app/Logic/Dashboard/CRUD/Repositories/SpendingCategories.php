<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\SpendingCategory;

use Illuminate\Contracts\Pagination\Paginator;

final class SpendingCategories
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getSpendingCategories(array $filters): Paginator
    {
        return SpendingCategory::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return SpendingCategory
     */
    public function storeSpendingCategory(array $credentials): SpendingCategory
    {
        $spendingCategory = SpendingCategory::create($credentials);

        return $spendingCategory;
    }

    /**
     * @param SpendingCategory $spendingCategory
     *
     * @param array $credentials
     *
     * @return SpendingCategory
     */
    public function updateSpendingCategory(SpendingCategory $spendingCategory, array $credentials): SpendingCategory
    {
        $spendingCategory->update($credentials);

        return $spendingCategory;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteSpendingCategory($id)
    {
        return SpendingCategory::destroy($id);
    }
}
