<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskFile;

use Illuminate\Database\Eloquent\Factories\Factory;

final class TaskFileFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = TaskFile::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $tasks = Task::all();

        return [
            'task_id' => $tasks->random(),

            'name' => $this->faker->text
        ];
    }
}
