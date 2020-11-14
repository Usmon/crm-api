<?php

namespace App\Logic\Auth\Services;

use App\Models\User;

use App\Logic\Auth\Contracts\Register as RegisterContract;

final class Register
{
    /**
     * @var
     */
    protected $repository;

    /**
     * @param RegisterContract $repository
     *
     * @return void
     */
    public function __construct(RegisterContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     *
     * @return User|null
     */
    public function createUser(array $data): ?User
    {
        return $this->repository->createUser($data);
    }
}
