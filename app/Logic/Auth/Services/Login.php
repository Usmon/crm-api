<?php

namespace App\Logic\Auth\Services;

use App\Models\User;

use App\Logic\Auth\Requests\Login as LoginRequest;

use Illuminate\Support\Facades\Hash;

use Jenssegers\Agent\Agent;

final class Login
{
    /**
     * @param User $user
     *
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
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

    /**
     * @param LoginRequest $request
     *
     * @return array
     */
    public function createCredentials(LoginRequest $request): array
    {
        return [
            'login' => $request->json('login'),

            'email' => $request->json('email'),

            'password' => $request->json('password'),
        ];
    }
}
