<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Spending;

use Illuminate\Contracts\Pagination\Paginator;

final class Spendings
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getSpendings(array $filters): Paginator
    {
        return Spending::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Spending
     */
    public function storeSpending(array $credentials): Spending
    {
        $spending = Spending::create($credentials);

        return $spending;
    }

    /**
     * @param Spending $spending
     *
     * @param array $credentials
     *
     * @return Spending
     */
    public function updateSpending(Spending $spending, array $credentials): Spending
    {
        $spending->update($credentials);

        return $spending;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteSpending($id)
    {
        return Spending::destroy($id);
    }
}
