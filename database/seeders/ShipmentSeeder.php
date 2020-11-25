<?php

namespace Database\Seeders;

use App\Models\Shipment;
use Illuminate\Database\Seeder;

final class ShipmentSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Shipment::factory()->times(100)->create();
    }
}
