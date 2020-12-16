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
        return Customer::with(['user','creator','referral'])->filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Customer
     */
    public function storeCustomer(array $credentials): Customer
    {
        $customer = Customer::create($credentials);

        return $customer;
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
