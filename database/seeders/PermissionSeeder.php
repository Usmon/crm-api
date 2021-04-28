<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class PermissionSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        \Spatie\Permission\Models\Permission::create([
            'name' => 'Orders',
        ]);

        \Spatie\Permission\Models\Permission::create([
            'name' => 'Pickups',
        ]);

        \Spatie\Permission\Models\Permission::create([
            'name' => 'Deliveries',
        ]);

        \Spatie\Permission\Models\Permission::create([
            'name' => 'Shipments',
        ]);

        \Spatie\Permission\Models\Permission::create([
            'name' => 'Boxes',
        ]);

        \Spatie\Permission\Models\Permission::create([
            'name' => 'Products',
        ]);

        \Spatie\Permission\Models\Permission::create([
            'name' => 'Customers',
        ]);

        \Spatie\Permission\Models\Permission::create([
            'name' => 'Drivers',
        ]);

    }
}
