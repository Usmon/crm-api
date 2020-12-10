<?php

namespace Database\Factories;

use App\Models\Task;

use App\Models\User;

use App\Models\Project;

use Illuminate\Database\Eloquent\Factories\Factory;

final class TaskFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Task::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        $projects = Project::all();

        return [
            'creator_id' => $users->random(),

            'project_id' => $projects->random(),

            'title' => $this->faker->text,

            'note' => $this->faker->text(),

            'remind_me_at' => $this->faker->dateTime,

            'due_date' => $this->faker->date(),

            'next_repeat' => $this->faker->dateTime
        ];
    }
}
