<?php

namespace Database\Seeders;

use App\Models\City;

use Illuminate\Database\Seeder;

final class CitySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        City::factory()->times(100)->create();
    }
}
