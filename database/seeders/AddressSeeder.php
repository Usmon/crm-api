<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

final class AddressSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Address::factory()->times(100)->create();
    }
}
