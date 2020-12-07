<?php

namespace Database\Factories;

use App\Models\Project;

use Illuminate\Database\Eloquent\Factories\Factory;

final class ProjectFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Project::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text
        ];
    }
}
