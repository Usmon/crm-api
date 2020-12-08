<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

final class TaskSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Task::factory()->times(100)->create();
    }
}
