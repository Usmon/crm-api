<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        User::factory()->create([
            'login' => 'axel',

            'email' => 'axel@silkroadexp.com',

            'password' => Hash::make('secret'),

            'profile' => [
                'first_name' => 'Sukhrob',

                'middle_name' => 'Sukhvatovich',

                'last_name' => 'Karshiev',

                'photo' => null,
            ],
        ]);

        User::factory()->count(99)->create();
    }
}
