<?php

namespace App\Logic\Auth\Contracts;

use App\Models\User;

interface Register
{
    /**
     * @param array $data
     *
     * @return User|null
     */
    public function createUser(array $data): ?User;
}
