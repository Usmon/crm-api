<?php

namespace App\Observers;

use App\Models\Driver;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class DriverObserver
{
    /**
     * @param Driver $driver
     *
     * @return void
     */
    public function creating(Driver $driver): void
    {
        $this->defaultProperties($driver);
    }

    /**
     * @param Driver $driver
     *
     * @return void
     */
    public function updating(Driver $driver): void
    {
        $this->defaultProperties($driver);
    }

    /**
     * @param Driver $driver
     *
     * @return void
     */
    public function deleting(Driver $driver): void
    {
        $driver->deleted_at = $driver->deleted_at ?? Carbon::now();
    }

    /**
     * @param Driver $driver
     *
     * @return void
     */
    public function restoring(Driver $driver): void
    {
        $driver->deleted_at = null;
    }

    /**
     * @param Driver $driver
     *
     * @return void
     */
    protected function defaultProperties(Driver $driver): void
    {
        $driver->creator_id = $driver->creator_id ?? Auth::id();

        $driver->license = $driver->license ?? null;

        $driver->created_at = $driver->created_at ?? Carbon::now();

        $driver->updated_at = $driver->updated_at ?? Carbon::now();

        $driver->deleted_at = $driver->deleted_at ?? null;
    }
}
