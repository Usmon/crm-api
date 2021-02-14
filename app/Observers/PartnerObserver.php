<?php

namespace App\Observers;

use App\Models\Partner;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class PartnerObserver
{
    /**
     * @param Partner $partner
     *
     * @return void
     */
    public function creating(Partner $partner): void
    {
        $this->defaultProperties($partner);
    }

    /**
     * @param Partner $partner
     *
     * @return void
     */
    public function updating(Partner $partner): void
    {
        $this->defaultProperties($partner);
    }

    /**
     * @param Partner $partner
     *
     * @return void
     */
    public function deleting(Partner $partner): void
    {
        $partner->deleted_at = $partner->deleted_at ?? Carbon::now();

        $partner->update();
    }

    /**
     * @param Partner $partner
     *
     * @return void
     */
    public function restoring(Partner $partner): void
    {
        $partner->deleted_at = null;
    }

    /**
     * @param Partner $partner
     *
     * @return void
     */
    protected function defaultProperties(Partner $partner): void
    {
        $partner->created_at = $partner->created_at ?? Carbon::now();

        $partner->updated_at = $partner->updated_at ?? Carbon::now();

        $partner->deleted_at = $partner->deleted_at ?? null;
    }
}
