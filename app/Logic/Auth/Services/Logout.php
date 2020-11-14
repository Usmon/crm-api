<?php

namespace App\Logic\Auth\Services;

use Exception;

use App\Models\User;

use App\Logic\Auth\Contracts\Logout as LogoutContract;

final class Logout
{
    /**
     * @var LogoutContract
     */
    protected $repository;

    /**
     * @param LogoutContract $repository
     *
     * @return void
     */
    public function __construct(LogoutContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param User $user
     *
     * @param string $token
     *
     * @return bool
     *
     * @throws Exception
     */
    public function deleteUserToken(User $user, string $token): bool
    {
        return $this->repository->deleteUserToken($user, $token);
    }
}
