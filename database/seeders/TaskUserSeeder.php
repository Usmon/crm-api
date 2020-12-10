<?php

namespace Database\Seeders;

use App\Models\TaskUser;

use Illuminate\Database\Seeder;

final class TaskUserSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        TaskUser::factory()->times(100)->create();
    }
}
