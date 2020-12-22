<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\SpendingCategory;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\SpendingCategories as SpendingCategoriesRequest;

final class SpendingCategories
{
    /**
     * @param SpendingCategoriesRequest $request
     *
     * @return array
     */
    public function getAllFilters(SpendingCategoriesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'name' => $request->json('name'),

            'parent_id' => $request->json('parent_id'),
        ];
    }

    /**
     * @param SpendingCategoriesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(SpendingCategoriesRequest $request): array
    {
        return $request->only('search', 'date', 'name', 'parent_id');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getSpendingCategories(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (SpendingCategory $spendingCategory) {
            return [
                'id' => $spendingCategory->id,

                'name' => $spendingCategory->name,

                'parent_id' => $spendingCategory->parent_id,

                'created_at' => $spendingCategory->created_at,

                'updated_at' => $spendingCategory->updated_at,

                'parent' => $spendingCategory->parent,
            ];
        });

        return $paginator;
    }

    /**
     * @param SpendingCategory $spendingCategory
     *
     * @return array
     */
    public function showSpendingCategory(SpendingCategory $spendingCategory): array
    {
        return [
            'id' => $spendingCategory->id,

            'name' => $spendingCategory->name,

            'parent_id' => $spendingCategory->parent_id,

            'created_at' => $spendingCategory->created_at,

            'updated_at' => $spendingCategory->updated_at,

            'parent' => $spendingCategory->parent,
        ];
    }

    /**
     * @param SpendingCategoriesRequest $request
     *
     * @return array
     */
    public function storeCredentials(SpendingCategoriesRequest $request): array
    {
        return [
            'name' => $request->json('name'),

            'parent_id' => $request->json('parent_id')
        ];
    }

    /**
     * @param SpendingCategoriesRequest $request
     *
     * @return array
     */
    public function updateCredentials(SpendingCategoriesRequest $request): array
    {
        $credentials = [
            'name' => $request->json('name'),

            'parent_id' => $request->json('parent_id')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteSpendingCategory($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
