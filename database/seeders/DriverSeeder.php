<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;

final class DriverSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Driver::factory()->times(5)->create();
    }
}
