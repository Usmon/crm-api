<?php

namespace App\Logic\Password\Services;

use Illuminate\Support\Str;

use App\Helpers\SendToEmail;

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
     * @param ForgotPasswordRequest $request
     *
     * @return string
     */
    public function getCustomURL(ForgotPasswordRequest $request): string
    {
        return $request->custom_url;
    }

    /**
     * @param string $email
     *
     * @param string $customURL
     *
     * @param string $token
     *
     * @return void
     */
    public function sendToEmail(string $email, string $customURL, string $token): void
    {
        SendToEmail::sentToEmail(
            $email,

            'Reset password',

            $customURL. '/?token='. $token
        );
    }

    /**
     * @return string
     */
    public function createRandomToken(): string
    {
        return  Str::random(50);
    }
}
