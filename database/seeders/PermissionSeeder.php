<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

final class PermissionSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Permission::factory()->createMany([
            [
                'name' => 'Search',
                'slug' => Str::slug('Search'),
                'description' => 'Permission for Search widget.',
            ],
            [
                'name' => 'Welcome',
                'slug' => Str::slug('Welcome'),
                'description' => 'Permission for Welcome widget.',
            ],
            [
                'name' => 'Financial overview',
                'slug' => Str::slug('Financial overview'),
                'description' => 'Permission for Financial overview widget.',
            ],
            [
                'name' => 'Monthly profit',
                'slug' => Str::slug('Monthly profit'),
                'description' => 'Permission for Monthly profit widget.',
            ],
            [
                'name' => 'Branch reputation',
                'slug' => Str::slug('Branch reputation'),
                'description' => 'Permission for Branch reputation widget.',
            ],
            [
                'name' => 'Customers',
                'slug' => Str::slug('Customers'),
                'description' => 'Permission for Customers widget.',
            ],
            [
                'name' => 'Expenses',
                'slug' => Str::slug('Expenses'),
                'description' => 'Permission for Expenses widget.',
            ],
            [
                'name' => 'Fedex',
                'slug' => Str::slug('Fedex'),
                'description' => 'Permission for Fedex widget.',
            ],
            [
                'name' => 'Pickups',
                'slug' => Str::slug('Pickups'),
                'description' => 'Permission for Pickups widget.',
            ],
            [
                'name' => 'Payment method',
                'slug' => Str::slug('Payment method'),
                'description' => 'Permission for Payment method widget.',
            ],
            [
                'name' => 'User view',
                'slug' => Str::slug('User view'),
                'description' => 'Permission for user view.',
            ],
            [
                'name' => 'User create',
                'slug' => Str::slug('User create'),
                'description' => 'Permission for user create.',
            ],
            [
                'name' => 'User read',
                'slug' => Str::slug('User read'),
                'description' => 'Permission for user read.',
            ],
            [
                'name' => 'User update',
                'slug' => Str::slug('User update'),
                'description' => 'Permission for user update.',
            ],
            [
                'name' => 'User delete',
                'slug' => Str::slug('User delete'),
                'description' => 'Permission for user delete.',
            ],
            [
                'name' => 'Token view',
                'slug' => Str::slug('Token view'),
                'description' => 'Permission for token view.',
            ],
            [
                'name' => 'Token create',
                'slug' => Str::slug('Token create'),
                'description' => 'Permission for token create.',
            ],
            [
                'name' => 'Token read',
                'slug' => Str::slug('Token read'),
                'description' => 'Permission for token read.',
            ],
            [
                'name' => 'Token update',
                'slug' => Str::slug('Token update'),
                'description' => 'Permission for token update.',
            ],
            [
                'name' => 'Token delete',
                'slug' => Str::slug('Token delete'),
                'description' => 'Permission for token delete.',
            ],
            [
                'name' => 'Role view',
                'slug' => Str::slug('Role view'),
                'description' => 'Permission for role view.',
            ],
            [
                'name' => 'Role create',
                'slug' => Str::slug('Role create'),
                'description' => 'Permission for role create.',
            ],
            [
                'name' => 'Role read',
                'slug' => Str::slug('Role read'),
                'description' => 'Permission for role read.',
            ],
            [
                'name' => 'Role update',
                'slug' => Str::slug('Role update'),
                'description' => 'Permission for role update.',
            ],
            [
                'name' => 'Role delete',
                'slug' => Str::slug('Role delete'),
                'description' => 'Permission for role delete.',
            ],
            [
                'name' => 'Permission view',
                'slug' => Str::slug('Permission view'),
                'description' => 'Permission for permission view.',
            ],
            [
                'name' => 'Permission create',
                'slug' => Str::slug('Permission create'),
                'description' => 'Permission for permission create.',
            ],
            [
                'name' => 'Permission read',
                'slug' => Str::slug('Permission read'),
                'description' => 'Permission for permission read.',
            ],
            [
                'name' => 'Permission update',
                'slug' => Str::slug('Permission update'),
                'description' => 'Permission for permission update.',
            ],
            [
                'name' => 'Permission delete',
                'slug' => Str::slug('Permission delete'),
                'description' => 'Permission for permission delete.',
            ],
            [
                'name' => 'User role view',
                'slug' => Str::slug('User role view'),
                'description' => 'Permission for user role view.',
            ],
            [
                'name' => 'User role create',
                'slug' => Str::slug('User role create'),
                'description' => 'Permission for user role create.',
            ],
            [
                'name' => 'User role read',
                'slug' => Str::slug('User role read'),
                'description' => 'Permission for user role read.',
            ],
            [
                'name' => 'User role update',
                'slug' => Str::slug('User role update'),
                'description' => 'Permission for user role update.',
            ],
            [
                'name' => 'User role delete',
                'slug' => Str::slug('User role delete'),
                'description' => 'Permission for user role delete.',
            ],
            [
                'name' => 'Role permission view',
                'slug' => Str::slug('Role permission view'),
                'description' => 'Permission for user role view.',
            ],
            [
                'name' => 'Role permission create',
                'slug' => Str::slug('Role permission create'),
                'description' => 'Permission for user role create.',
            ],
            [
                'name' => 'Role permission read',
                'slug' => Str::slug('Role permission read'),
                'description' => 'Permission for user role read.',
            ],
            [
                'name' => 'Role permission update',
                'slug' => Str::slug('Role permission update'),
                'description' => 'Permission for user role update.',
            ],
            [
                'name' => 'Role permission delete',
                'slug' => Str::slug('Role permission delete'),
                'description' => 'Permission for user role delete.',
            ],
        ]);
    }
}
