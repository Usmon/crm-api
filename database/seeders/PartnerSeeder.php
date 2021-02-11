<?php

namespace Database\Seeders;

use App\Models\Partner;

use Illuminate\Database\Seeder;

final class PartnerSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Partner::factory()->times(5)->create();
    }
}
