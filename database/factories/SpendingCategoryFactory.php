<?php

namespace Database\Factories;

use App\Models\SpendingCategory;

use Illuminate\Database\Eloquent\Factories\Factory;

final class SpendingCategoryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = SpendingCategory::class;

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
