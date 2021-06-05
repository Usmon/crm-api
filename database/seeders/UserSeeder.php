<?php

namespace Database\Seeders;

use App\Models\Address;

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
        $user = User::factory()->create([
            'login' => 'axel',

            'email' => 'axel@silkroadexp.com',

            'full_name' => 'Sukhrob Karshiev Sukhvatovich',

            'password' => Hash::make('secret'),

            'profile' => [
                'first_name' => 'Sukhrob',

                'middle_name' => 'Sukhvatovich',

                'last_name' => 'Karshiev',

                'photo' => null,
            ],

            'partner_id' => Partner::all('id')->random()
        ]);

        if (config('app.env') == 'prod') {
            $user->each(function (User $user) {
                $this->phoneCreate($user);

                $this->addressCreate($user);

                $user->assignRole('Administrator');
            });

            User::factory()->times(200)->create()->each(function (User $user) {
                $this->phoneCreate($user);

                $this->addressCreate($user);
            });
        }
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

    /**
     * @param User $user
     *
     * @return void
     */
    private function addressCreate(User $user): void
    {
        $user->addresses()->saveMany(Address::factory()->times(1)->create());
    }
}
