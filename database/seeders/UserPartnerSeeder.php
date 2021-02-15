<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

use App\Models\Partner;

final class UserPartnerSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {

            $partner = Partner::inRandomOrder()->first(['id']);

            $user->update([
                'partner_id' => $partner->id
            ]);
        }
    }
}
