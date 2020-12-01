<?php

namespace Database\Seeders;

use App\Models\Pickup;

use Illuminate\Database\Seeder;

final class PickupSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Pickup::factory()->times(100)->create();
    }
}
