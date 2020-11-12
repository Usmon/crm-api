<?php

namespace App\Observers;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

final class RoleObserver
{
    /**
     * @param Role $role
     *
     * @return void
     */
    public function creating(Role $role): void
    {
        $this->defaultProperties($role);
    }

    /**
     * @param Role $role
     *
     * @return void
     */
    public function updating(Role $role): void
    {
        $this->defaultProperties($role);
    }

    /**
     * @param Role $role
     *
     * @return void
     */
    public function deleting(Role $role): void
    {
        $role->deleted_at = $role->deleted_at ?? Carbon::now();
    }

    /**
     * @param Role $role
     *
     * @return void
     */
    public function restoring(Role $role): void
    {
        $role->deleted_at = null;
    }

    /**
     * @param Role $role
     *
     * @return void
     */
    protected function defaultProperties(Role $role): void
    {
        $role->slug = $role->slug !== Str::slug($role->name) ? Str::slug($role->name) : $role->slug;

        $role->description = $role->description ?? null;

        $role->created_at = $role->created_at ?? Carbon::now();

        $role->updated_at = $role->updated_at ?? Carbon::now();

        $role->deleted_at = $role->deleted_at ?? null;
    }
}
