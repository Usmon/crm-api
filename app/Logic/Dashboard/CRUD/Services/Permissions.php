<?php

namespace App\Logic\Dashboard\CRUD\Services;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Permissions as PermissionsRequest;

use Spatie\Permission\Models\Permission;

final class Permissions
{
    /**
     * @param PermissionsRequest $request
     * @return array
     */
    public function getAllFilters(PermissionsRequest $request): array
    {
        return [
            'search' => $request->json('search'),
        ];
    }

    /**
     * @param PermissionsRequest $request
     * @return array
     */
    public function getOnlyFilters(PermissionsRequest $request): array
    {
        return $request->only('search');
    }

    /**
     * @param PermissionsRequest $request
     * @return array
     */
    public function getAllSorts(PermissionsRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param PermissionsRequest $request
     * @return array
     */
    public function getOnlySorts(PermissionsRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getPermissions(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Permission $permission) {
            return [
                'id' => $permission->id,

                'name' => $permission->name,

                'created_at' => $permission->created_at,

                'updated_at' => $permission->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param Permission $permission
     * @return array
     */
    public function showPermission(Permission $permission): array
    {
        return [
            'id' => $permission->id,

            'name' => $permission->name,

            'created_at' => $permission->created_at,
        ];
    }

    /**
     * @param PermissionsRequest $request
     * @return array
     */
    public function storeCredentials(PermissionsRequest $request): array
    {
        return [
            'name' => $request->json('name'),
        ];
    }

    /**
     * @param PermissionsRequest $request
     * @return array
     */
    public function updateCredentials(PermissionsRequest $request): array
    {
        return [
            'name' => $request->json('name'),
        ];
    }


    /**
     * @param $id
     *
     * @return array|int
     */
    public function deletePermission($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
