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

        Box::factory()->times(32)->create(['order_id' => 1]);
    }
}
