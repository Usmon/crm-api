<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use Spatie\Permission\Models\Permission;

use Illuminate\Contracts\Pagination\Paginator;

final class Permissions
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getPermissions(array $filters, array $sorts): Paginator
    {
        return Permission::paginate(10);
    }

    /**
     * @param array $credentials
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function storePermission(array $credentials)
    {
        $permission = Permission::create($credentials);

        return $permission;
    }

    /**
     * @param Permission $permission
     * @param array $credentials
     * @return Permission
     */
    public function updatePermission(Permission $permission, array $credentials)
    {
        $permission->update($credentials);

        return $permission;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deletePermission($id)
    {
        return Permission::destroy($id);
    }
}
