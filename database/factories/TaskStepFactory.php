<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStep;

use Illuminate\Database\Eloquent\Factories\Factory;

final class TaskStepFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = TaskStep::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $tasks = Task::all();

        return [
            'task_id' => $tasks->random(),

            'step' => $this->faker->text
        ];
    }
}
