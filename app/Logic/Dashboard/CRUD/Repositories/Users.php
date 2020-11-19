<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use Exception;

use App\Models\User;

use Illuminate\Support\Arr;

use Illuminate\Database\Eloquent\Collection;

final class Users
{
    /**
     * @param array $filters
     *
     * @return Collection
     */
    public function getUsers(array $filters): Collection
    {
        return User::filter($filters)->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param array $credentials
     *
     * @return USer
     */
    public function storeUser(array $credentials): USer
    {
        $user = new User;

        $user->fill(Arr::except($credentials, 'roles'));

        $user->save();

        if ($credentials['roles']) {
            $user->roles()->attach($credentials['roles']);
        }

        return $user;
    }

    /**
     * @param User $user
     *
     * @param array $credentials
     *
     * @return User
     */
    public function updateUser(User $user, array $credentials): User
    {
        $user->update(Arr::except($credentials, 'roles'));

        if ($credentials['roles']) {
            $user->roles()->sync($credentials['roles']);
        }

        return $user;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function deleteUser(User $user): bool
    {
        try {
            $user->delete();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
