<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\User;

use App\Logic\Dashboard\CRUD\Requests\Users as UsersRequest;

use Illuminate\Contracts\Pagination\Paginator;

use Illuminate\Support\Arr;

use Illuminate\Support\Facades\Hash;

final class Users
{
    /**
     * @param UsersRequest $request
     *
     * @return array
     */
    public function getAllFilters(UsersRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'role' => $request->json('role'),
        ];
    }

    /**
     * @param UsersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(UsersRequest $request): array
    {
        return $request->only('search', 'date', 'role');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getUsers(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (User $user) {
            return [
                'id' => $user->id,

                'login' => $user->login,

                'email' => $user->email,

                'profile' => $user->profile,

                'created_at' => $user->created_at,

                'updated_at' => $user->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function showUser(User $user): array
    {
        return [
            'id' => $user->id,

            'login' => $user->login,

            'email' => $user->email,

            'profile' => $user->profile,

            'created_at' => $user->created_at,

            'updated_at' => $user->updated_at,
        ];
    }

    /**
     * @param UsersRequest $request
     *
     * @return array
     */
    public function storeCredentials(UsersRequest $request): array
    {
        return [
            'login' => $request->json('login'),

            'email' => $request->json('email'),

            'password' => Hash::make($request->json('password')),

            'profile' => $request->json('profile'),

            'roles' => $request->json('roles'),
        ];
    }

    /**
     * @param UsersRequest $request
     *
     * @return array
     */
    public function updateCredentials(UsersRequest $request): array
    {
        $credentials = [
            'login' => $request->json('login'),

            'email' => $request->json('email'),

            'profile' => $request->json('profile'),

            'roles' => $request->json('roles'),
        ];

        if ($request->json('password')) {
            Arr::add($credentials, 'password', Hash::make($request->json('password')));
        }

        return $credentials;
    }
}
