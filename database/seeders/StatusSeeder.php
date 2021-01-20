<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

final class StatusSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Status::factory()->times(5)->create();
    }
}
