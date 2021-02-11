<?php

namespace App\Logic\Password\Repositories;

use App\Models\User;

final class Forgot
{
    /**
     * @param string $email
     *
     * @param string $token
     */
    public function updateUser(string $email, string $token): void
    {
        User::where('email', '=', $email)->update([
            'reset_token' => $token
        ]);
    }
}
