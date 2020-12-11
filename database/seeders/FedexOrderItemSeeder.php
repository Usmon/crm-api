<?php

namespace Database\Seeders;

use App\Models\FedexOrderItem;

use Illuminate\Database\Seeder;

final class FedexOrderItemSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        FedexOrderItem::factory()->times(100)->create();
    }
}
