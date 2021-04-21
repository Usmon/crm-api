<?php

namespace Database\Seeders;

use App\Models\Permission;

use Illuminate\Database\Seeder;

final class PermissionSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Permission::factory()->createMany([
//            [
//                'name' => 'Search',
//
//                'slug' => 'Search',
//
//                'description' => 'Permission for Search widget.',
//            ],

//            [
//                'name' => 'Welcome',
//
//                'slug' => 'Welcome',
//
//                'description' => 'Permission for Welcome widget.',
//            ],

            [
                'name' => 'Address',

                'slug' => 'dashboard.addresses',

                'description' => 'Permission for Address widget.',
            ],

            [
                'name' =>   'Box',

                'slug' => 'dashboard.boxes.box',

                'description' => 'Permission for Box widget.',
            ],

            [
                'name' => 'Product',

                'slug' => 'dashboard.boxes.items',

                'description' => 'Permission for Product widget.',
            ],

            [
                'name' => 'City',

                'slug' => 'dashboard.cities',

                'description' => 'Permission for City widget.',
            ],

            [
                'name' => 'Customers',

                'slug' => 'dashboard.customers',

                'description' => 'Permission for Customer widget.',
            ],

            [
                'name' => 'Delivery',

                'slug' => 'dashboard.deliveries',

                'description' => 'Permission for Delivery widget.',
            ],

            [
                'name' => 'Driver',

                'slug' => 'dashboard.drivers.',

                'description' => 'Permission for Driver widget.'
            ],

            [
                'name' => 'Fedex',

                'slug' => 'dashboard.fedex-orders.',

                'description' => 'Permission for Fedex widget.',
            ],

            [
                'name' => 'Orders',

                'slug' => 'dashboard.orders.order.',

                'description' => 'Permission for Order widget.'
            ],

            [
                'name' => 'Partners',

                'slug' => 'dashboard.partners',

                'description' => 'Permission for Partner widget.'
            ],

            [
                'name' => 'Pickups',

                'slug' => 'dashboard.pickups',

                'description' => 'Permission for Pickup widget.',
            ],

            [
                'name' => 'Shipments',

                'slug' => 'dashboard.shipments',

                'description' => 'Permission for Shipment widget.',
            ],

            [
                'name' => 'Statuses',

                'slug' => 'dashboard.status.statuses',

                'description' => 'Permission for Status widget.',
            ],

//            [
//                'name' => 'Financial overview',
//
//                'slug' => Str::slug('Financial overview'),
//
//                'description' => 'Permission for Financial overview widget.',
//            ],
//
//            [
//                'name' => 'Monthly profit',
//
//                'slug' => Str::slug('Monthly profit'),
//
//                'description' => 'Permission for Monthly profit widget.',
//            ],
//
//            [
//                'name' => 'Branch reputation',
//
//                'slug' => Str::slug('Branch reputation'),
//
//                'description' => 'Permission for Branch reputation widget.',
//            ],

//            [
//                'name' => 'Expenses',
//
//                'slug' => Str::slug('Expenses'),
//
//                'description' => 'Permission for Expenses widget.',
//            ],

//            [
//                'name' => 'Payment method',
//
//                'slug' => 'Payment method',
//
//                'description' => 'Permission for Payment method widget.',
//            ],


//            [
//                'name' => 'User view',
//
//                'slug' => 'User view',
//
//                'description' => 'Permission for user view.',
//            ],
//
//            [
//                'name' => 'User create',
//
//                'slug' => 'User create',
//
//                'description' => 'Permission for user create.',
//            ],
//
//            [
//                'name' => 'User read',
//
//                'slug' => 'User read',
//
//                'description' => 'Permission for user read.',
//            ],
//
//            [
//                'name' => 'User update',
//
//                'slug' => 'User update',
//
//                'description' => 'Permission for user update.',
//            ],
//
//            [
//                'name' => 'User delete',
//
//                'slug' => 'User delete',
//
//                'description' => 'Permission for user delete.',
//            ],
//
//            [
//                'name' => 'Role view',
//
//                'slug' => 'Role view',
//
//                'description' => 'Permission for role view.',
//            ],
//
//            [
//                'name' => 'Role create',
//
//                'slug' => 'Role create',
//
//                'description' => 'Permission for role create.',
//            ],
//
//            [
//                'name' => 'Role read',
//
//                'slug' => 'Role read',
//
//                'description' => 'Permission for role read.',
//            ],
//
//            [
//                'name' => 'Role update',
//
//                'slug' => 'Role update',
//
//                'description' => 'Permission for role update.',
//            ],
//
//            [
//                'name' => 'Role delete',
//
//                'slug' => 'Role delete',
//
//                'description' => 'Permission for role delete.',
//            ],
        ]);
    }
}
