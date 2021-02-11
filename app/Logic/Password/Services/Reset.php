<?php

namespace App\Logic\Password\Services;

use Illuminate\Support\Facades\Hash;

use App\Logic\Password\Requests\Token as TokenRequest;

use App\Logic\Password\Requests\Reset as ResetPasswordRequest;

final class Reset
{
    /**
     * @param TokenRequest $token
     *
     * @param ResetPasswordRequest $request
     *
     * @return array
     */
    public function getProperties(TokenRequest $token, ResetPasswordRequest $request): array
    {
        return [
            'token' => $token['token'],

            'reset_token' => null,

            'password' => Hash::make($request->password)
        ];
    }
}
