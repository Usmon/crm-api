<?php

namespace Database\Seeders;

use App\Models\OrderComment;
use Illuminate\Database\Seeder;

final class OrderCommentSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        OrderComment::factory()->times(100)->create();
    }
}
