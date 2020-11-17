<?php

namespace App\Logic\Auth\Services;

use App\Models\User;

use App\Logic\Auth\Requests\Logout as LogoutRequest;

final class Logout
{
    /**
     * @param LogoutRequest $request
     *
     * @return User|null
     */
    public function getUser(LogoutRequest $request): ?User
    {
        return $request->user() ?? null;
    }

    /**
     * @param LogoutRequest $request
     *
     * @return string|null
     */
    public function getBearerToken(LogoutRequest $request): ?string
    {
        return $request->bearerToken() ?? null;
    }
}
