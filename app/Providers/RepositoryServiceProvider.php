<?php

namespace App\Providers;

use App\Logic\Auth\Contracts\Login as AuthLoginContract;

use App\Logic\Auth\Contracts\Logout as AuthLogoutContract;

use App\Logic\Auth\Contracts\Register as AuthRegisterContract;

use App\Logic\Auth\Repositories\Login as AuthLoginRepository;

use App\Logic\Auth\Repositories\Logout as AuthLogoutRepository;

use App\Logic\Auth\Repositories\Register as AuthRegisterRepository;

use Illuminate\Support\ServiceProvider;

final class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(AuthLoginContract::class, AuthLoginRepository::class);

        $this->app->bind(AuthLogoutContract::class, AuthLogoutRepository::class);

        $this->app->bind(AuthRegisterContract::class, AuthRegisterRepository::class);
    }
}
