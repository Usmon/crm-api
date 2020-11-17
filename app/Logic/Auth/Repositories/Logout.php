<?php

namespace App\Logic\Auth\Repositories;

use Exception;

use App\Models\User;

use App\Models\Token;

final class Logout
{
    /**
     * @param User $user
     *
     * @param string|null $token
     *
     * @return bool
     */
    public function deleteToken(User $user, string $token = null): bool
    {
        $token = Token::findBy($token)->first();

        if (! $token) {
            return false;
        }

        if ($token->deleted_at) {
            return false;
        }

        if ($user->id !== $token->user_id) {
            return false;
        }

        try {
            $token->delete();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
