<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Role;
use App\Models\Token;
use App\Models\Permission;

use App\Observers\UserObserver;
use App\Observers\RoleObserver;
use App\Observers\TokenObserver;
use App\Observers\PermissionObserver;

use Illuminate\Support\ServiceProvider;

final class ObserverServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Role::observe(RoleObserver::class);
        Token::observe(TokenObserver::class);
        Permission::observe(PermissionObserver::class);
    }
}
