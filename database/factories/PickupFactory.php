<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Driver;

use App\Models\Sender;

use App\Models\Pickup;

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
        $users = User::all();

        $senders = Sender::all();

        $drivers = Driver::all();

        $pickupDatetimeStart = $this->faker->dateTimeThisYear('+1 month');

        $pickupDatetimeEnd   = strtotime('+1 Week', $pickupDatetimeStart->getTimestamp());

        return [
            'pickup_datetime_start' => $pickupDatetimeStart,

            'pickup_datetime_end' => $pickupDatetimeEnd,

            'sender_id' => $senders->random(),

            'driver_id' => $drivers->random(),

            'creator_id' => $users->random(),
        ];
    }
}
