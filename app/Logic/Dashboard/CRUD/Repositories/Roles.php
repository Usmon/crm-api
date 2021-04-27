<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use Exception;

use Spatie\Permission\Models\Role;

use Illuminate\Support\Arr;

use Illuminate\Database\Eloquent\Collection;

final class Roles
{
    /**
     * @param array $filters
     *
     * @return Collection
     */
    public function getRoles(array $filters): Collection
    {
        return Role::filter($filters)->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param array $credentials
     *
     * @return Role
     */
    public function storeRole(array $credentials): Role
    {
        $role = new Role;

        $role->fill(Arr::except($credentials, 'permissions'));

        $role->save();

        if ($credentials['permissions']) {
            $role->permissions()->attach($credentials['permissions']);
        }

        return $role;
    }

    /**
     * @param Role $role
     *
     * @param array $credentials
     *
     * @return Role
     */
    public function updateRole(Role $role, array $credentials): Role
    {
        $role->update(Arr::except($credentials, 'permissions'));

        if ($credentials['permissions']) {
            $role->permissions()->sync($credentials['permissions']);
        }

        return $role;
    }

    /**
     * @param Role $role
     *
     * @return bool
     */
    public function deleteRole(Role $role): bool
    {
        try
        {
            $role->delete();
        }
        catch (Exception $e)
        {
            return false;
        }

        return true;
    }

}

