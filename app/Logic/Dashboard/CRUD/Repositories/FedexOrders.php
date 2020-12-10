<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use Exception;

use App\Models\FedexOrder;

use Illuminate\Contracts\Pagination\Paginator;

final class FedexOrders
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getFedexOrders(array $filters): Paginator
    {
        return FedexOrder::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return FedexOrder
     */
    public function storeFedexOrder(array $credentials): FedexOrder
    {
        $fedexOrder = FedexOrder::create($credentials);

        return $fedexOrder;
    }

    /**
     * @param FedexOrder $fedexOrder
     * @param array $credentials
     * @return FedexOrder
     */
    public function updateFedexOrder(FedexOrder $fedexOrder, array $credentials): FedexOrder
    {
        $fedexOrder->update($credentials);

        return $fedexOrder;
    }

    /**
     * @param FedexOrder $fedexOrder
     * @return bool
     */
    public function deleteFedexOrder(FedexOrder $fedexOrder): bool
    {
        try {
            $fedexOrder->delete();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
