<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\User;

use App\Models\Phone;

use App\Models\Message;

use App\Helpers\SendToPhone;

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
     * @return array
     */
    public function storeMessage(array $credentials)
    {
        $receiver_id = [];

        foreach ($credentials['phones'] as $phone)
        {
            $receiver_id [] = Phone::query()->where('phone','=',$phone)->first()->user_id;
        }

        $messages = [];

        foreach ($receiver_id as $id)
        {
            $messages[] = Message::query()->create([
                'receiver_id' => $id,

                'body' => $credentials['body'],
            ]);

            $user = User::query()->find($id)->full_name;

            SendToPhone::sendToPhone($phone, $user.' : '.$credentials['body']);
        }

        return $messages;
    }

    /**
     * @param Message $message
     *
     * @param array $credentials
     *
     * @return Message
     */
    public function updateMessage(Message $message, array $credentials): Message
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

    public function getMessagesUser(array $credentials)
    {
        $messages = Message::query()
            ->where([['receiver_id', '=', $credentials['user_id']],
                ['sender_id', '=', $credentials['current_user_id']]])

            ->orWhere([['sender_id', '=', $credentials['user_id']],
                ['receiver_id', '=', $credentials['current_user_id']]])

            ->orderBy('id', 'DESC')

            ->pager();

        return $messages;
    }
}
