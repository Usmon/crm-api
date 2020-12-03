<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Feedback;

use Illuminate\Database\Eloquent\Factories\Factory;

final class FeedbackFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Feedback::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        return [
            'staff_id' => $users->random(),

            'customer_id' => $users->random(),

            'message' => $this->faker->text
        ];
    }
}
