<?php

namespace Database\Seeders;

use App\Models\TaskFile;

use Illuminate\Database\Seeder;

final class TaskFileSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        TaskFile::factory()->times(100)->create();
    }
}
