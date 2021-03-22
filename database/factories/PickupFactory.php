<?php

namespace Database\Factories;

use App\Models\Status;

use App\Models\User;

use App\Models\Driver;

use App\Models\Customer;

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

        $customers = Customer::all();

        $drivers = Driver::all();

        $statuses = Status::all();

        $pickupDatetimeStart = $this->faker->dateTimeThisYear('+1 month');

        $pickupDatetimeEnd   = strtotime('+1 Week', $pickupDatetimeStart->getTimestamp());

        return [
            'type' => json_encode([
                'index' => 'pickup',

                'date' => [
                    'pickup_datetime_start' => now(),

                    'pickup_datetime_end' => now(),

                ],
            ]),

            'status_id' => $statuses->random(),

            'sender_id' => $customers->random(),

            'driver_id' => $drivers->random(),

            'creator_id' => $users->random(),
        ];
    }
}
