<?php

namespace Database\Seeders;

use App\Models\Role;

use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

final class RoleSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Role::factory()->createMany([
            [
                'name' => 'Administrator',

                'slug' => Str::slug('Administrator'),

                'description' => 'Administrator role description.',
            ],

            [
                'name' => 'Customer',

                'slug' => Str::slug('Customer'),

                'description' => 'Customer role description.',
            ],
        ]);
    }
}
