<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Partner;

use Illuminate\Contracts\Pagination\Paginator;

final class Partners
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getPartners(array $filters, array $sorts): Paginator
    {
        return Partner::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Partner
     */
    public function storePartner(array $credentials): Partner
    {
        $partner = Partner::create($credentials);

        return $partner;
    }


    /**
     * @param Partner $partner
     *
     * @param array $credentials
     *
     * @return Partner
     */
    public function updatePartner(Partner $partner, array $credentials): Partner
    {
        $partner->update($credentials);

        return $partner;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deletePartner($id)
    {
        return Partner::destroy($id);
    }
}