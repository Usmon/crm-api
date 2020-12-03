<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $this->call(RoleSeeder::class);

        $this->call(PermissionSeeder::class);

        $this->call(ShipmentSeeder::class);

        $this->call(FedexOrderSeeder::class);

        $this->call(PickupSeeder::class);

        $this->call(OrderSeeder::class);

        $this->call(DeliverySeeder::class);
      
        $this->call(SenderSeeder::class);

        $this->call(WarehouseItemSeeder::class);
    }
}
