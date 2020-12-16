<?php

namespace Database\Seeders;

use App\Models\OrderUser;
use Illuminate\Database\Seeder;

final class OrderUserSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        OrderUser::factory()->times(100)->create();
    }
}
