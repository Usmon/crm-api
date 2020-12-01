<?php

namespace Database\Factories;

use App\Models\Pickup;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

final class PickupFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Pickup::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $user = User::all();
        $startingDate = $this->faker->dateTimeThisYear('+1 month');
        $endingDate   = strtotime('+1 Week', $startingDate->getTimestamp());

        return [
            'note' => $this->faker->text(),
            'bring_address' => random_int(100,1000)/100,
            'bring_datetime_start' => $startingDate,
            'bring_datetime_end' => $endingDate,
            'staff_id' => $user->random(),
            'driver_id' => $user->random(),
            'customer_id' => $user->random(),
        ];
    }
}
