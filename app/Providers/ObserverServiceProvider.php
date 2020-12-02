<?php

namespace App\Providers;

use App\Models\Order;

use App\Models\Shipment;

use App\Models\FedexOrder;

use App\Models\User;

use App\Models\Role;

use App\Models\Token;

use App\Models\Pickup;

use App\Models\Delivery;

use App\Models\Permission;

use App\Observers\OrderObserver;

use App\Observers\ShipmentObserver;

use App\Observers\UserObserver;

use App\Observers\RoleObserver;

use App\Observers\PickupObserver;

use App\Observers\DeliveryObserver;

use App\Observers\TokenObserver;

use App\Observers\FedexOrderObserver;

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

        Pickup::observe(PickupObserver::class);

        Delivery::observe(DeliveryObserver::class);

        Token::observe(TokenObserver::class);

        FedexOrder::observe(FedexOrderObserver::class);

        Permission::observe(PermissionObserver::class);

        Shipment::observe(ShipmentObserver::class);

        Order::observe(OrderObserver::class);
    }
}
