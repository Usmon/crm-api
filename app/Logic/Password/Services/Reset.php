<?php

namespace App\Logic\Password\Services;

use Illuminate\Support\Facades\Hash;

use App\Logic\Password\Requests\Reset as ResetPasswordRequest;

final class Reset
{
    /**
     * @param ResetPasswordRequest $request
     *
     * @return mixed
     */
    public function getToken(ResetPasswordRequest $request): string
    {
        return $request->token;
    }

    /**
     * @param ResetPasswordRequest $request
     *
     * @return string
     */
    public function getPassword(ResetPasswordRequest $request): string
    {
        return Hash::make($request->password);
    }
}
