<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Address;

use Illuminate\Contracts\Pagination\Paginator;

final class Addresses
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getAddresses(array $filters, array $sorts): Paginator
    {
        return Address::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Address
     */
    public function storeAddress(array $credentials): Address
    {
        $address = Address::create($credentials);

        return $address;
    }


    /**
     * @param Address $address
     *
     * @param array $credentials
     *
     * @return Address
     */
    public function updateAddress(Address $address, array $credentials): Address
    {
        $address->update($credentials);

        return $address;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteAddress($id)
    {
        return Address::destroy($id);
    }
}
