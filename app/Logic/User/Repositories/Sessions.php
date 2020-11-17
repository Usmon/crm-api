<?php

namespace App\Logic\User\Repositories;

use Exception;

use App\Models\User;

use App\Models\Token;

use Illuminate\Database\Eloquent\Collection;

final class Sessions
{
    /**
     * @param User $user
     *
     * @return Collection
     */
    public function all(User $user): Collection
    {
        return $user->tokens()->orderBy('used_at', 'desc')->get();
    }

    /**
     * @param User $user
     *
     * @param string $token
     *
     * @return void
     */
    public function other(User $user, string $token): void
    {
        Token::query()->where('value', '!=', $token)->where('user_id', '=', $user->id)->delete();
    }

    /**
     * @param User $user
     *
     * @param Token $token
     *
     * @return bool
     */
    public function delete(User $user, Token $token): bool
    {
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
