<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Spending;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Spendings as SpendingsRequest;

final class Spendings
{
    /**
     * @param SpendingsRequest $request
     *
     * @return array
     */
    public function getAllFilters(SpendingsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'amount' => $request->json('amount'),

            'category_id' => $request->json('category_id'),

            'note' => $request->json('note'),
        ];
    }

    /**
     * @param SpendingsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(SpendingsRequest $request): array
    {
        return $request->only('search', 'date', 'amount', 'category_id', 'note');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getSpendings(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Spending $spending) {
            return [
                'id' => $spending->id,

                'amount' => $spending->amount,

                'category_id' => $spending->category_id,

                'note' => $spending->note,

                'created_at' => $spending->created_at,

                'updated_at' => $spending->updated_at,

                'category' => $spending->category,
            ];
        });

        return $paginator;
    }

    /**
     * @param Spending $spending
     *
     * @return array
     */
    public function showSpending(Spending $spending): array
    {
        return [
            'id' => $spending->id,

            'amount' => $spending->amount,

            'category_id' => $spending->category_id,

            'note' => $spending->note,

            'created_at' => $spending->created_at,

            'updated_at' => $spending->updated_at,

            'category' => $spending->category,
        ];
    }

    /**
     * @param SpendingsRequest $request
     *
     * @return array
     */
    public function storeCredentials(SpendingsRequest $request): array
    {
        return [
            'amount' => $request->json('amount'),

            'category_id' => $request->json('category_id'),

            'note' => $request->json('note')
        ];
    }

    /**
     * @param SpendingsRequest $request
     *
     * @return array
     */
    public function updateCredentials(SpendingsRequest $request): array
    {
        $credentials = [
            'amount' => $request->json('amount'),

            'category_id' => $request->json('category_id'),

            'note' => $request->json('note')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteSpending($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
