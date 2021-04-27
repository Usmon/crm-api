<?php

namespace App\Logic\Dashboard\CRUD\Services;

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
    public function getRoles(Collection $collection): Collection
    {
        return $collection->transform(function (Role $role) {
            return [
                'id' => $role->id,

                'name' => $role->name,

                'slug' => $role->slug,

                'description' => $role->description,

                'created_at' => $role->created_at,

                'updated_at' => $role->updated_at,
            ];
        });
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

            'slug' => $role->slug,

            'description' => $role->description,

            'created_at' => $role->created_at,

            'updated_at' => $role->updated_at,
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
