<?php

namespace Database\Seeders;

use App\Models\DeliveryComment;

use Illuminate\Database\Seeder;

final class DeliveryCommentSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        DeliveryComment::factory()->times(100)->create();
    }
}
