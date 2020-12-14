<?php

namespace Database\Seeders;

use App\Models\DeliveryUser;
use Illuminate\Database\Seeder;

final class DeliveryUserSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        DeliveryUser::factory()->times(100)->create();
    }
}
