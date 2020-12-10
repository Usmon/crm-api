<?php

namespace Database\Seeders;

use App\Models\TaskStep;
use Illuminate\Database\Seeder;

final class TaskStepSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        TaskStep::factory()->times(100)->create();
    }
}
