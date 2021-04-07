<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Recipient;

use App\Models\User;

use Illuminate\Contracts\Pagination\Paginator;

final class Recipients
{
    /**
     * @param array $filters
     *
     * @param array $sorts
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
        $user = User::factory()->create($credentials['user']);

        //Binding sender
        $user->customer()->create()->recipient()->create();

        //Create address for user
        $user->addresses()->create($credentials['address']);

        //Create phone for user
        $user->phones()->create(['phone' => $credentials['phone']]);

        return $user->customer->recipient;
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
    public function deleteRecipient($id): int
    {
        return Recipient::destroy($id);
    }

    /**
     * @param string $phone
     *
     * @return Recipient
     */
    public function checkPhone(string $phone): Recipient
    {
        return Recipient::filter(['customer' => $phone])->first();
    }
}
