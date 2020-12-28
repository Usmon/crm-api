<?php

namespace Database\Factories;

use App\Models\Box;

use App\Models\User;

use App\Models\Tracking;

use Illuminate\Database\Eloquent\Factories\Factory;

final class TrackingFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Tracking::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $customers = User::all();

        $boxes = Box::all();

        return [
            'customer_id' => $customers->random(),

            'tracking' => $this->faker->unique()->numberBetween(1000,100000),

            'box_id' => $boxes->random(),
        ];
    }
}
