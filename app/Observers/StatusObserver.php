<?php

namespace App\Observers;

use App\Models\Status;

use Illuminate\Support\Carbon;

final class StatusObserver
{
    /**
     * @param Status $status
     *
     * @return void
     */
    public function creating(Status $status): void
    {
        $this->defaultProperties($status);
    }

    /**
     * @param Status $status
     *
     * @return void
     */
    public function updating(Status $status): void
    {
        $this->defaultProperties($status);
    }

    /**
     * @param Status $status
     *
     * @return void
     */
    public function deleting(Status $status): void
    {
        $status->deleted_at = $status->deleted_at ?? Carbon::now();
    }

    /**
     * @param Status $status
     *
     * @return void
     */
    public function restoring(Status $status): void
    {
        $status->deleted_at = null;
    }

    /**
     * @param Status $status
     *
     * @return void
     */
    protected function defaultProperties(Status $status): void
    {
        $status->created_at = $status->created_at ?? Carbon::now();

        $status->updated_at = $status->updated_at ?? Carbon::now();

        $status->deleted_at = $status->deleted_at ?? null;
    }
}
