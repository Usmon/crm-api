<?php

namespace Database\Seeders;

use App\Models\BoxItem;

use Illuminate\Database\Seeder;

final class BoxItemSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        BoxItem::factory()->times(100)->create();
    }
}
