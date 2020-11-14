<?php

namespace App\Logic\Auth\Contracts;

use Exception;

use App\Models\User;

interface Logout
{
    /**
     * @param User $user
     *
     * @param string $token
     *
     * @return bool
     *
     * @throws Exception
     */
    public function deleteUserToken(User $user, string $token): bool;
}
