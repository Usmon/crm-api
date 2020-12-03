<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;

final class FeedbackSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Feedback::factory()->times(100)->create();
    }
}
