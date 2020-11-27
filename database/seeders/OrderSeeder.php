<?php

namespace Database\Seeders;

use App\Models\Order;

use Illuminate\Database\Seeder;

final class OrderSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Order::factory()->times(100)->create();
    }
}
