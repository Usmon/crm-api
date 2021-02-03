<?php

namespace Database\Factories;

use App\Models\Status;

use Illuminate\Database\Eloquent\Factories\Factory;

final class StatusFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Status::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'model' => $this->faker->slug,

            'key' => $this->faker->slug(3),

            'value' => $this->faker->text(5),

            'parameters' => json_encode([
                'body1' => $this->faker->text(5),

                'body2' => $this->faker->text(5),
            ]),
        ];
    }
}
