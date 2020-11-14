<?php

namespace App\Logic\Auth\Services;

use App\Models\User;

use App\Logic\Auth\Contracts\Login as LoginContract;

final class Login
{
    /**
     * @var LoginContract
     */
    protected $repository;

    /**
     * @param LoginContract $repository
     *
     * @return void
     */
    public function __construct(LoginContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $login
     *
     * @return User|null
     */
    public function getUser(string $login): ?User
    {
        return $this->repository->getUser($login);
    }

    /**
     * @param User $user
     *
     * @param array $device
     *
     * @return string|null
     */
    public function createToken(User $user, array $device): ?string
    {
        return $this->repository->createToken($user, $device);
    }
}
