<?php

namespace App\Observers;

use App\Models\Recipient;

use Illuminate\Support\Carbon;

final class RecipientObserver
{
    /**
     * @param Recipient $recipient
     *
     * @return void
     */
    public function creating(Recipient $recipient): void
    {
        $this->defaultProperties($recipient);
    }

    /**
     * @param Recipient $recipient
     *
     * @return void
     */
    public function updating(Recipient $recipient): void
    {
        $this->defaultProperties($recipient);
    }

    /**
     * @param Recipient $recipient
     *
     * @return void
     */
    public function deleting(Recipient $recipient): void
    {
        $recipient->deleted_at = $recipient->deleted_at ?? Carbon::now();
    }

    /**
     * @param Recipient $recipient
     *
     * @return void
     */
    public function restoring(Recipient $recipient): void
    {

        $recipient->deleted_at = null;
    }

    /**
     * @param Recipient $recipient
     *
     * @return void
     */
    protected function defaultProperties(Recipient $recipient): void
    {
        $recipient->created_at = $recipient->created_at ?? Carbon::now();

        $recipient->updated_at = $recipient->updated_at ?? Carbon::now();

        $recipient->deleted_at = $recipient->deleted_at ?? null;
    }
}
