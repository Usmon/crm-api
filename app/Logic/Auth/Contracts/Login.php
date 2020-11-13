<?php

namespace App\Logic\Auth\Contracts;

use App\Models\User;

interface Login
{
    /**
     * @param string $login
     *
     * @return User|null
     */
    public function getUserByLogin(string $login): ?User;

    /**
     * @param User $user
     * @param array $device
     *
     * @return string|null
     */
    public function createTokenForUser(User $user, array $device): ?string;
}
