<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

final class ProductSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Product::factory()->times(100)->create();
    }
}
