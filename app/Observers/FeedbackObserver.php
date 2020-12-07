<?php

namespace App\Observers;

use App\Models\Feedback;

use Illuminate\Support\Carbon;

final class FeedbackObserver
{
    /**
     * @param Feedback $feedback
     *
     * @return void
     */
    public function creating(Feedback $feedback): void
    {
        $this->defaultProperties($feedback);
    }

    /**
     * @param Feedback $feedback
     *
     * @return void
     */
    public function updating(Feedback $feedback): void
    {
        $this->defaultProperties($feedback);
    }

    /**
     * @param Feedback $feedback
     *
     * @return void
     */
    public function deleting(Feedback $feedback): void
    {
        $feedback->deleted_at = $feedback->deleted_at ?? Carbon::now();
    }

    /**
     * @param Feedback $feedback
     *
     * @return void
     */
    public function restoring(Feedback $feedback): void
    {
        $feedback->deleted_at = null;
    }

    /**
     * @param Feedback $feedback
     *
     * @return void
     */
    protected function defaultProperties(Feedback $feedback): void
    {
        $feedback->created_at = $feedback->created_at ?? Carbon::now();

        $feedback->updated_at = $feedback->updated_at ?? Carbon::now();

        $feedback->deleted_at = $feedback->deleted_at ?? null;
    }
}
