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

            'username' => $request->json('username'),

            'date' => $request->json('date'),

            'role' => $request->json('role'),

            'only_corporate' => $request->json('only_corporate'),
        ];
    }

    /**
     * @param UsersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(UsersRequest $request): array
    {
        return $request->only('search', 'date', 'role', 'only_corporate', 'username');
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

                'full_name' => $user->full_name,

                'login' => $user->login,

                'phones' => $user->getPhonesWithLimit(),

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

            'full_name' => $user->full_name,

            'partner' => [
                'id' => $user->partner_id,

                'name' => $user->partner->name
            ],

            'login' => $user->login,

            'email' => $user->email,

            'profile' => $user->profile,

            'created_at' => $user->created_at,

            'updated_at' => $user->updated_at,

            'roles' => $user->getRoleNames(),

            'phones' => $user->phones->transform(function ($data){
                return $data->phone;
            }),
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
            'full_name' => $request->json('full_name'),

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
            'full_name' => $request->json('full_name'),

            'login' => $request->json('login'),

            'email' => $request->json('email'),

            'profile' => $request->json('profile'),

            'roles' => $request->json('roles'),

            'partner_id' => $request->json('partner_id')
        ];

        if ($request->json('password')) {
            Arr::add($credentials, 'password', Hash::make($request->json('password')));
        }

        return $credentials;
    }
}
