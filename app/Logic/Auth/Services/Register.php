<?php

namespace App\Logic\Auth\Services;

use App\Logic\Auth\Requests\Register as RegisterRequest;

use Illuminate\Support\Facades\Hash;

final class Register
{
    /**
     * @param RegisterRequest $request
     *
     * @return array
     */
    public function createCredentials(RegisterRequest $request): array
    {
        return [
            'login' => $request->json('login'),

            'email' => $request->json('email'),

            'password' => Hash::make($request->json('password')),
        ];
    }
}
