<?php

namespace Database\Seeders;

use App\Models\ShipmentUser;

use Illuminate\Database\Seeder;

final class ShipmentUserSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        ShipmentUser::factory()->times(100)->create();
    }
}
