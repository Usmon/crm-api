<?php

namespace App\Logic\Password\Repositories;

use App\Models\User;

final class Reset
{
    /**
     * @param string $token
     *
     * @param string $password
     */
    public function updateUser(string $token, string $password): void
    {
        User::where('reset_token', '=', $token)->update([
            'reset_token' => null,

            'password' => $password,
        ]);
    }
}
