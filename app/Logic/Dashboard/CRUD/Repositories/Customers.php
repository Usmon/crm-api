<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Customer;

use Illuminate\Contracts\Pagination\Paginator;

final class Customers
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getCustomers(array $filters): Paginator
    {
        return Customer::with(['user','creator','referral'])->filter($filters)->senderOrRecipient($filters['only_recipient'] ?? false)->orderBy('id', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Customer
     */
    public function storeCustomer(array $credentials): Customer
    {
        return Customer::create($credentials);
    }

    /**
     * @param Customer $customer
     *
     * @param array $credentials
     *
     * @return Customer
     */
    public function updateCustomer(Customer $customer, array $credentials): Customer
    {
        $customer->update($credentials);

        return $customer;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteCustomer($id)
    {
        return Customer::destroy($id);
    }
}
