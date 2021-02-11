<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Status;

use Illuminate\Contracts\Pagination\Paginator;

use Illuminate\Support\Collection;

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
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Collection
     */
    public function getStatusesByModel(string $model_name): Collection
    {
        return Status::byModel($model_name)->get();
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
