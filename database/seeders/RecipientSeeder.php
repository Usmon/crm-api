<?php

namespace Database\Seeders;

use App\Models\Recipient;
use Illuminate\Database\Seeder;

final class RecipientSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Recipient::factory()->times(100)->create();
    }
}
