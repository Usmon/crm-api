<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Phone;

use Illuminate\Contracts\Pagination\Paginator;

final class Phones
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getPhones(array $filters, array $sorts): Paginator
    {
        return Phone::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Phone
     */
    public function storePhone(array $credentials): Phone
    {
        $phone = Phone::create($credentials);

        return $phone;
    }


    /**
     * @param Phone $phone
     *
     * @param array $credentials
     *
     * @return Phone
     */
    public function updatePhone(Phone $phone, array $credentials): Phone
    {
        $phone->update($credentials);

        return $phone;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deletePhone($id)
    {
        return Phone::destroy($id);
    }
}
