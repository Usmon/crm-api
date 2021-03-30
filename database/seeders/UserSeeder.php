<?php

namespace Database\Seeders;

use App\Models\Partner;

use App\Models\User;

use App\Models\Phone;

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

            'partner_id' => Partner::all('id')->random()
        ])->each(function (User $user) {
            $this->phoneCreate($user);
        });

        User::factory()->times(200)->create()->each(function (User $user) {
            $this->phoneCreate($user);
        });
    }

    /**
     * @param User $user
     *
     * @return void
     */
    private function phoneCreate(User $user): void
    {
        $user->phones()->saveMany(Phone::factory()->times(5)->create());
    }
}
