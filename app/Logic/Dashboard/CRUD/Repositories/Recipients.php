<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Recipient;

use Illuminate\Contracts\Pagination\Paginator;

final class Recipients
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getRecipients(array $filters, array $sorts): Paginator
    {
        return Recipient::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Recipient
     */
    public function storeRecipient(array $credentials): Recipient
    {
        $recipient = Recipient::create($credentials);

        return $recipient;
    }

    /**
     * @param Recipient $recipient
     *
     * @param array $credentials
     *
     * @return Recipient
     */
    public function updateRecipient(Recipient $recipient, array $credentials): Recipient
    {
        $recipient->update($credentials);

        return $recipient;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteRecipient($id)
    {
        return Recipient::destroy($id);
    }
}
