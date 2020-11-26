<?php

namespace Database\Seeders;

use App\Models\FedexOrder;

use Illuminate\Database\Seeder;

final class FedexOrderSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        FedexOrder::factory()->times(100)->create();
    }
}
