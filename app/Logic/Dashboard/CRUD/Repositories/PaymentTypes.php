<?php


namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\PaymentType;

/**
 * Class PaymentTypes
 * @package App\Logic\Dashboard\CRUD\Repositories
 */
class PaymentTypes
{
    /**
     * Get all items.
     *
     * @return PaymentType[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTypes()
    {
        return PaymentType::all();
    }

    /**
     * Get one item.
     *
     * @param int $id
     *
     * @return PaymentType
     */
    public function getById(int $id): PaymentType
    {
        return PaymentType::find($id);
    }
}
