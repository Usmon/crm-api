<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

final class PermissionSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $orders = \Spatie\Permission\Models\Permission::create([
            'name' => 'Orders',
        ]);

        $pickups = \Spatie\Permission\Models\Permission::create([
            'name' => 'Pickups',
        ]);

        $deliveries = \Spatie\Permission\Models\Permission::create([
            'name' => 'Deliveries',
        ]);

        $shipments = \Spatie\Permission\Models\Permission::create([
            'name' => 'Shipment',
        ]);

        $shipments = \Spatie\Permission\Models\Permission::create([
            'name' => 'Boxes',
        ]);

        $shipments = \Spatie\Permission\Models\Permission::create([
            'name' => 'Products',
        ]);



//        Role::findById(1)->givePermissionTo([
//            $orders,
//
//            $pickups,
//
//            $deliveries,
//
//            $shipments,
//        ]);
    }
}
