<?php

namespace Database\Seeders;

use App\Models\ShipmentComment;
use Illuminate\Database\Seeder;

final class ShipmentCommentSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        ShipmentComment::factory()->times(100)->create();
    }
}
