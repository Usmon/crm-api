<?php

namespace App\Logic\Auth\Repositories;

use App\Models\User;

use App\Models\Token;

use Illuminate\Support\Str;

final class Login
{
    /**
     * @param string $key
     *
     * @param string|null $value
     *
     * @return User|null
     */
    public function getUser(string $key, string $value = null): ?User
    {
        return User::findBy($key, $value)->first() ?? null;
    }

    /**
     * @param User $user
     *
     * @param array $device
     *
     * @return Token|null
     */
    public function createToken(User $user, array $device = []): ?Token
    {
        $token = new Token([
            'value' => hash('sha256', $user->id . $user->login . $user->email . Str::random(40)),

            'device' => $device,

            'user_id' => $user->id,
        ]);

        $token->save();

        return $token ?? null;
    }
}
