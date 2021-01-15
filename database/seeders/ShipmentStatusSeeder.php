<?php

namespace Database\Seeders;

use App\Models\ShipmentStatus;

use Illuminate\Database\Seeder;

final class ShipmentStatusSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        ShipmentStatus::factory()->times(10)->create();
    }
}
