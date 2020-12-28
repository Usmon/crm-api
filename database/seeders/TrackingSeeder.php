<?php

namespace Database\Seeders;

use App\Models\Tracking;
use Illuminate\Database\Seeder;

final class TrackingSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Tracking::factory()->times(100)->create();
    }
}
