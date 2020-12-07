<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

final class ProjectSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Project::factory()->times(100)->create();
    }
}
