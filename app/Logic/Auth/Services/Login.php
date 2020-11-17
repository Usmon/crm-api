<?php

namespace App\Logic\Auth\Services;

use App\Logic\Auth\Requests\Login as LoginRequest;

use Illuminate\Support\Facades\Hash;

use Jenssegers\Agent\Agent;

final class Login
{
    /**
     * @param string $hashedPassword
     *
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword(string $hashedPassword, string $password): bool
    {
        return Hash::check($password, $hashedPassword);
    }

    /**
     * @param LoginRequest $request
     *
     * @return array
     */
    public function createDevice(LoginRequest $request): array
    {
        $agent = new Agent;

        $agent->setUserAgent($request->userAgent());

        return [
            'ip' => $request->ip(),

            'os' => $agent->platform(),

            'type' => $agent->deviceType(),

            'name' => $agent->browser() ?? $agent->device(),
        ];
    }
}
