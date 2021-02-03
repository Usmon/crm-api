<?php

namespace App\Logic\Password\Services;

use Illuminate\Support\Str;

use App\Logic\Password\Requests\Forgot as ForgotPasswordRequest;

final class Forgot
{

    /**
     * @param ForgotPasswordRequest $request
     *
     * @return string
     */
    public function getEmail(ForgotPasswordRequest $request): string
    {
        return $request->email;
    }

    /**
     * @return string
     */
    public function createRandomToken(): string
    {
        return  Str::random(50);
    }
}
