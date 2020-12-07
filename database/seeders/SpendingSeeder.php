<?php

namespace Database\Seeders;

use App\Models\Spending;

use Illuminate\Database\Seeder;

final class SpendingSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Spending::factory()->times(100)->create();
    }
}
