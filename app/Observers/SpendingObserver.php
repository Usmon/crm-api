<?php

namespace App\Observers;

use App\Models\Spending;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class SpendingObserver
{
    /**
     * @param Spending $spending
     *
     * @return void
     */
    public function creating(Spending $spending): void
    {
        $this->defaultProperties($spending);
    }

    /**
     * @param Spending $spending
     *
     * @return void
     */
    public function updating(Spending $spending): void
    {
        $this->defaultProperties($spending);
    }

    /**
     * @param Spending $spending
     *
     * @return void
     */
    public function deleting(Spending $spending): void
    {
        $spending->deleted_by = Auth::id();

        $spending->deleted_at = $spending->deleted_at ?? Carbon::now();

        $spending->update();
    }

    /**
     * @param Spending $spending
     *
     * @return void
     */
    public function restoring(Spending $spending): void
    {
        $spending->deleted_at = null;
    }

    /**
     * @param Spending $spending
     *
     * @return void
     */
    protected function defaultProperties(Spending $spending): void
    {
        $spending->created_at = $spending->created_at ?? Carbon::now();

        $spending->updated_at = $spending->updated_at ?? Carbon::now();

        $spending->deleted_at = $spending->deleted_at ?? null;

        $spending->creator_id = $spending->creator_id ?? Auth::id();
    }
}
