<?php

namespace Database\Seeders;

use App\Models\Phone;

use Illuminate\Database\Seeder;

final class PhoneSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Phone::factory()->times(1)->create();
    }
}
