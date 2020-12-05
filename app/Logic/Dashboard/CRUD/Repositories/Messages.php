<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Message;

use Illuminate\Contracts\Pagination\Paginator;

final class Messages
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getMessages(array $filters): Paginator
    {
        return Message::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Message
     */
    public function storeMessage(array $credentials): Message
    {
        $message = Message::create($credentials);

        return $message;
    }

    /**
     * @param Message $message
     *
     * @param array $credentials
     *
     * @return Message
     */
    public function updateRecipient(Message $message, array $credentials): Message
    {
        $message->update($credentials);

        return $message;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteMessage($id)
    {
        return Message::destroy($id);
    }
}
