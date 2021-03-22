<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Sender;

use Illuminate\Contracts\Pagination\Paginator;

final class Senders
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getSenders(array $filters, array $sorts): Paginator
    {
        return Sender::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Sender
     */
    public function storeSender(array $credentials): Sender
    {
        $order = Sender::create($credentials);

        return $order;
    }

    /**
     * @param Sender $sender
     *
     * @param array $credentials
     *
     * @return Sender
     */
    public function updateSender(Sender $sender, array $credentials): Sender
    {
        $sender->update($credentials);

        return $sender;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteSender(int $id): int
    {
        return Sender::destroy($id);
    }

    /**
     * @param string $phone
     *
     * @return Sender
     */
    public function checkPhone(string $phone): Sender
    {
        return Sender::filter(['customer' => $phone])->first();
    }
}
