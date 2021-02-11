<?php

namespace App\Logic\Password\Repositories;

use App\Models\User;

final class Reset
{
    /**
     * @param array $credentials
     *
     * @return void
     */
    public function updateUser(array $credentials): void
    {
        User::where('reset_token', '=', $credentials['token'])->update([
            'reset_token' => $credentials['reset_token'],

            'password' => $credentials['password'],
        ]);
    }
}
