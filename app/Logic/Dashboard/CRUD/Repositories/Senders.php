<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Sender;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

use Illuminate\Database\Eloquent\Collection;

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
        $user = User::factory()->create($credentials['user']);

        //Binding sender
        $user->customer()->create()->sender()->create();

        //Create address for user
        $user->addresses()->create($credentials['address']);

        //Create phone for user
        $user->phones()->create(['phone' => $credentials['phone']]);

        return $user->customer->sender;
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

        $sender->customer()->update($credentials['customer']);

        $sender->customer->user()->update($credentials['user']);

        $sender->customer->user->phones()->first()->update(['phone' => $credentials['phone']]);

        $sender->customer->user->addresses()->first()->update($credentials['address']);

        $sender->update($credentials);

        return $sender->refresh();
    }

    /**
     * @param int $id
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
        return Sender::filterPhone($phone)->first();
    }

    /**
     * @param string $phone
     *
     * @return Collection
     */
    public function searchByPhone(string $phone): Collection
    {
        return Sender::filterPhone($phone)->get();
    }
}
