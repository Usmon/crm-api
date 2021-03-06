<?php

namespace App\Observers;

use App\Models\Message;

use Illuminate\Support\Carbon;

final class MessageObserver
{
    /**
     * @param Message $message
     *
     * @return void
     */
    public function creating(Message $message): void
    {
        $this->defaultProperties($message);
    }

    public function insert(Message $message): void
    {
        $this->defaultProperties($message);
    }

    /**
     * @param Message $message
     *
     * @return void
     */
    public function updating(Message $message): void
    {
        $this->defaultProperties($message);
    }

    /**
     * @param Message $message
     *
     * @return void
     */
    public function deleting(Message $message): void
    {
        $message->deleted_at = $message->deleted_at ?? Carbon::now();
    }

    /**
     * @param Message $message
     *
     * @return void
     */
    public function restoring(Message $message): void
    {
        $message->deleted_at = null;
    }

    /**
     * @param Message $message
     *
     * @return void
     */
    protected function defaultProperties(Message $message): void
    {
        $message->sender_id = $message->sender_id ?? auth()->id();

        $message->created_at = $message->created_at ?? Carbon::now();

        $message->updated_at = $message->updated_at ?? Carbon::now();

        $message->deleted_at = $message->deleted_at ?? null;
    }
}
