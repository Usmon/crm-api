<?php

namespace App\Observers;

use App\Models\Sender;

use Illuminate\Support\Carbon;

final class SenderObserver
{
    /**
     * @param Sender $sender
     *
     * @return void
     */
    public function creating(Sender $sender): void
    {
        $this->defaultProperties($sender);
    }

    /**
     * @param Sender $sender
     *
     * @return void
     */
    public function updating(Sender $sender): void
    {
        $this->defaultProperties($sender);
    }

    /**
     * @param Sender $sender
     *
     * @return void
     */
    public function deleting(Sender $sender): void
    {
        $sender->deleted_at = $sender->deleted_at ?? Carbon::now();
    }

    /**
     * @param Sender $sender
     *
     * @return void
     */
    public function restoring(Sender $sender): void
    {

        $sender->deleted_at = null;
    }

    /**
     * @param Sender $sender
     *
     * @return void
     */
    protected function defaultProperties(Sender $sender): void
    {
        $sender->created_at = $order->created_at ?? Carbon::now();

        $sender->updated_at = $order->updated_at ?? Carbon::now();

        $sender->deleted_at = $order->deleted_at ?? null;
    }
}
