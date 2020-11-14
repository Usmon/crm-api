<?php

namespace App\Observers;

use App\Models\Token;

use Illuminate\Support\Carbon;

final class TokenObserver
{
    /**
     * @param Token $token
     *
     * @return void
     */
    public function creating(Token $token): void
    {
        $this->defaultProperties($token);
    }

    /**
     * @param Token $token
     *
     * @return void
     */
    public function updating(Token $token): void
    {
        $this->defaultProperties($token);
    }

    /**
     * @param Token $token
     *
     * @return void
     */
    public function deleting(Token $token): void
    {
        $token->deleted_at = $token->deleted_at ?? Carbon::now();
    }

    /**
     * @param Token $token
     *
     * @return void
     */
    public function restoring(Token $token): void
    {
        $token->deleted_at = null;
    }

    protected function defaultProperties(Token $token): void
    {
        $token->device = $token->device ?? Token::DEFAULT_DEVICE;

        $token->used_at = $token->used_at ?? Carbon::now();

        $token->created_at = $token->created_at ?? Carbon::now();

        $token->updated_at = $token->updated_at ?? Carbon::now();

        $token->deleted_at = $token->deleted_at ?? null;
    }
}
