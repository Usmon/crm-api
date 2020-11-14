<?php

namespace App\Logic\Auth\Repositories;

use Exception;

use App\Models\User;

use App\Models\Token;

use App\Logic\Auth\Contracts\Logout as LogoutContract;

final class Logout implements LogoutContract
{
    /**
     * @param User $user
     *
     * @param string $token
     *
     * @return bool
     *
     * @throws Exception
     */
    public function deleteUserToken(User $user, string $token): bool
    {
        $token = Token::findByValue($token)->first();

        if (! $token) {
            return false;
        }

        if ($token->trashed()) {
            return false;
        }

        if ($user->id !== $token->user_id) {
            return false;
        }

        return (bool) $token->delete();
    }
}
