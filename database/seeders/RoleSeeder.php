<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Seeder;

final class RoleSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $role = Role::create([
            'name' => 'Administrator',
        ]);
        $permissionsId = Permission::all()->map(function ($data){
            return $data->id;
        });
        $role->givePermissionTo($permissionsId);
    }
}
