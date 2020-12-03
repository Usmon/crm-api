<?php

namespace Database\Seeders;

use App\Models\Delivery;

use Illuminate\Database\Seeder;

final class DeliverySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Delivery::factory()->times(100)->create();
    }
}
