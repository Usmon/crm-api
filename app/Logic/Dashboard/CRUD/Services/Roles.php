<?php

namespace App\Logic\Dashboard\CRUD\Services;

use Illuminate\Contracts\Pagination\Paginator;
use Spatie\Permission\Models\Role;

use App\Logic\Dashboard\CRUD\Requests\Roles as RolesRequest;

use Illuminate\Database\Eloquent\Collection;

final class Roles
{
    /**
     * @param RolesRequest $request
     *
     * @return array
     */
    public function getAllFilters(RolesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'permissions' => $request->json('permissions'),
        ];
    }

    /**
     * @param RolesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(RolesRequest $request): array
    {
        return $request->only('search', 'date', 'permissions');
    }

    /**
     * @param Collection $collection
     *
     * @return Collection
     */
    public function getRoles(Paginator $collection)
    {
        $collection->getCollection()->transform(function (Role $role) {
            return [
                'id' => $role->id,

                'name' => $role->name,

                'count_permissions' => $role->permissions()->count(),

                'created_at' => $role->created_at,

                'updated_at' => $role->updated_at,
            ];
        });

        return $collection;
    }

    /**
     * @param Role $role
     *
     * @return array
     */
    public function showRole(Role $role): array
    {
        return [
            'id' => $role->id,

            'name' => $role->name,

            'created_at' => $role->created_at,

            'updated_at' => $role->updated_at,

            'permissions' => $role->permissions
        ];
    }

    /**
     * @param RolesRequest $request
     *
     * @return array
     */
    public function storeCredentials(RolesRequest $request): array
    {
        return [
            'name' => $request->json('name'),

            'slug' => $request->json('slug'),

            'description' => $request->json('description'),

            'permissions' => $request->json('permissions'),
        ];
    }

    /**
     * @param RolesRequest $request
     *
     * @return array
     */
    public function updateCredentials(RolesRequest $request): array
    {
        $credentials = [
            'name' => $request->json('name'),

            'slug' => $request->json('slug'),

            'description' => $request->json('description'),

            'permissions' => $request->json('permissions'),
        ];

        return $credentials;
    }


}
