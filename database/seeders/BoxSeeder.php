<?php

namespace Database\Seeders;

use App\Models\Box;

use Illuminate\Database\Seeder;

final class BoxSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Box::factory()->times(100)->create();
    }
}
