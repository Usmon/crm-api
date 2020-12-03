<?php

namespace Database\Seeders;

use App\Models\WarehouseItem;

use Illuminate\Database\Seeder;

final class WarehouseItemSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        WarehouseItem::factory()->times(100)->create();
    }
}
