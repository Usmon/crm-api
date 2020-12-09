<?php

namespace Database\Factories;

use App\Models\Task;

use App\Models\User;

use App\Models\TaskUser;

use Illuminate\Database\Eloquent\Factories\Factory;

final class TaskUserFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = TaskUser::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        $tasks = Task::all();

        return [
            'user_id' => $users->random(),

            'task_id' => $tasks->random()
        ];
    }
}
