<?php

namespace Database\Seeders;

use App\Models\OrderHistory;

use Illuminate\Database\Seeder;

final class OrderHistorySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        OrderHistory::factory()->times(100)->create();
    }
}
