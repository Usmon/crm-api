<?php

namespace Database\Seeders;

use App\Models\SpendingCategory;
use Illuminate\Database\Seeder;

final class SpendingCategorySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        SpendingCategory::factory()->times(100)->create();
    }
}
