<?php

namespace App\Logic\Auth\Repositories;

use App\Models\User;

use Illuminate\Support\Str;

use App\Logic\Auth\Contracts\Login as LoginContract;

final class Login implements LoginContract
{
    /**
     * @param string $login
     *
     * @return User|null
     */
    public function getUserByLogin(string $login): ?User
    {
        $user = User::findByLogin($login)->first();

        if ($user) {
            return $user;
        }

        return null;
    }

    /**
     * @param User $user
     * @param array $device
     *
     * @return string|null
     */
    public function createTokenForUser(User $user, array $device): ?string
    {
        $token = $user->tokens()->create([
            'value' => hash('sha256', $user->id . $user->login . $user->email . Str::random(40)),
            'device' => $device,
        ]);

        if ($token) {
            return $token->value;
        }

        return null;
    }
}
