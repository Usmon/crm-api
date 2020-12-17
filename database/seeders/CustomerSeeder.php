<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

final class CustomerSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Customer::factory()->times(100)->create();
    }
}
