<?php

namespace App\Logic\Auth\Repositories;

use App\Models\User;

final class Register
{
    /**
     * @param array $data
     *
     * @return User|null
     */
    public function createUser(array $data): ?User
    {
        $user = new User($data);

        $user->save();

        return $user ?? null;
    }
}
