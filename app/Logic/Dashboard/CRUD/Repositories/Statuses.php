<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Status;

use Illuminate\Contracts\Pagination\Paginator;

final class Statuses
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getStatuses(array $filters, array $sorts): Paginator
    {
        return Status::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Status
     */
    public function storeStatus(array $credentials): Status
    {
        $status = Status::create($credentials);

        return $status;
    }


    /**
     * @param Status $status
     *
     * @param array $credentials
     *
     * @return Status
     */
    public function updateStatus(Status $status, array $credentials): Status
    {
        $status->update($credentials);

        return $status;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteStatus($id): int
    {
        return Status::destroy($id);
    }
}
