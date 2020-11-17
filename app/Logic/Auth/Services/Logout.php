<?php

namespace App\Logic\Auth\Services;

use App\Models\User;

use Illuminate\Http\Request;

final class Logout
{
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
