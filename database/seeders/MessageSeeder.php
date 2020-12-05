<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

final class MessageSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Message::factory()->times(100)->create();
    }
}
