<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Message;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Messages as MessagesRequest;

final class Messages
{
    /**
     * @param MessagesRequest $request
     *
     * @return array
     */
    public function getAllFilters(MessagesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'sender_id' => $request->json('sender_id'),

            'receiver_id' => $request->json('receiver_id'),

            'body' => $request->json('body'),
        ];
    }

    /**
     * @param MessagesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(MessagesRequest $request): array
    {
        return $request->only('search', 'date', 'sender_id', 'receiver_id', 'body');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getMessages(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Message $message) {
            return [
                'id' => $message->id,

                'sender_id' => $message->sender_id,

                'receiver_id' => $message->receiver_id,

                'body' => $message->body,

                'created_at' => $message->created_at,

                'updated_at' => $message->updated_at,

                'deleted_at' => $message->deleted_at,

                'sender' => $message->sender,

                'receiver' => $message->receiver,
            ];
        });

        return $paginator;
    }

    /**
     * @param Message $message
     *
     * @return array
     */
    public function showMessage(Message $message): array
    {
        return [
            'id' => $message->id,

            'sender_id' => $message->sender_id,

            'receiver_id' => $message->receiver_id,

            'body' => $message->body,

            'created_at' => $message->created_at,

            'updated_at' => $message->updated_at,

            'deleted_at' => $message->deleted_at,

            'sender' => $message->sender,

            'receiver' => $message->receiver
        ];
    }

    /**
     * @param MessagesRequest $request
     *
     * @return array
     */
    public function storeCredentials(MessagesRequest $request): array
    {

        return [
            'sender_id' => $request->json('sender_id'),

            'receiver_id' => $request->json('receiver_id'),

            'body' => $request->json('body')
        ];
    }

    /**
     * @param MessagesRequest $request
     *
     * @return array
     */
    public function updateCredentials(MessagesRequest $request): array
    {
        $credentials = [
            'sender_id' => $request->json('sender_id'),

            'receiver_id' => $request->json('receiver_id'),

            'body' => $request->json('body')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteMessage($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
