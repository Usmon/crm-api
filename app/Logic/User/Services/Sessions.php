<?php

namespace App\Logic\User\Services;

use App\Models\User;

use App\Models\Token;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Collection;

final class Sessions
{
    /**
     * @param Collection $collection
     *
     * @param string $currentToken
     *
     * @return Collection
     */
    public function getAll(Collection $collection, string $currentToken): Collection
    {
        return $collection->transform(function (Token $token) use ($currentToken) {
            return [
                'id' => $token->id,

                'ip' => $token->device['ip'],

                'os' => $token->device['os'],

                'type' => $token->device['type'],

                'name' => $token->device['name'],

                'current' => $token->value === $currentToken,

                'used_at' => $token->used_at->diffForHumans(),
            ];
        });
    }

    /**
     * @param Request $request
     *
     * @return User
     */
    public function getUser(Request $request): User
    {
        return $request->user();
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function getBearerToken(Request $request): string
    {
        return $request->bearerToken();
    }
}
