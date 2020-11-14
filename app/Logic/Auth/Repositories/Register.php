<?php

namespace App\Logic\Auth\Repositories;

use App\Models\User;

use App\Logic\Auth\Contracts\Register as RegisterContract;

final class Register implements RegisterContract
{
    /**
     * @param array $data
     *
     * @return User|null
     */
    public function createUser(array $data): ?User
    {
        $user = new User;

        $user->fill($data);

        $user->save();

        if ($user) {
            return $user;
        }

        return null;
    }
}
