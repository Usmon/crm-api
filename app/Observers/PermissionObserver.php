<?php

namespace App\Observers;

use App\Models\Permission;

use Illuminate\Support\Str;

use Illuminate\Support\Carbon;

final class PermissionObserver
{
    /**
     * @param Permission $permission
     *
     * @return void
     */
    public function creating(Permission $permission): void
    {
        $this->defaultProperties($permission);
    }

    /**
     * @param Permission $permission
     *
     * @return void
     */
    public function updating(Permission $permission): void
    {
        $this->defaultProperties($permission);
    }

    /**
     * @param Permission $permission
     *
     * @return void
     */
    public function deleting(Permission $permission): void
    {
        $permission->deleted_at = $permission->deleted_at ?? Carbon::now();
    }

    /**
     * @param Permission $permission
     *
     * @return void
     */
    public function restoring(Permission $permission): void
    {
        $permission->deleted_at = null;
    }

    /**
     * @param Permission $permission
     *
     * @return void
     */
    protected function defaultProperties(Permission $permission): void
    {
//        $permission->slug = $permission->slug !== Str::slug($permission->name) ? Str::slug($permission->name) : $permission->slug;

        $permission->description = $permission->description ?? null;

        $permission->created_at = $permission->created_at ?? Carbon::now();

        $permission->updated_at = $permission->updated_at ?? Carbon::now();

        $permission->deleted_at = $permission->deleted_at ?? null;
    }
}
