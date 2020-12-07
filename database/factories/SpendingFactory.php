<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Spending;

use App\Models\SpendingCategory;

use Illuminate\Database\Eloquent\Factories\Factory;

final class SpendingFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Spending::class;

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function definition(): array
    {
        $users = User::all();

        $spendingCategories = SpendingCategory::all();

        return [
            'creator_id' => $users->random(),

            'amount' => random_int(100,1000)/100,

            'category_id' => $spendingCategories->random(),

            'note' => $this->faker->text
        ];
    }
}
