<?php

namespace Database\Seeders;

use App\Models\Sender;

use Illuminate\Database\Seeder;

final class SenderSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Sender::factory()->times(100)->create();
    }
}
