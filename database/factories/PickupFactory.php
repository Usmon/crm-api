<?php

namespace Database\Factories;

use App\Models\Sender;

use App\Models\Status;

use App\Models\User;

use App\Models\Driver;

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

        $statuses = Status::all();

        return [
            'type' => json_encode([
                'index' => 'pickup',

                'date' => [
                    'from' => now(),

                    'to' => now(),

                ],
            ]),

            'status_id' => $statuses->random(),

            'sender_id' => $senders->random(),

            'driver_id' => $drivers->random(),

            'creator_id' => $users->random(),
        ];
    }
}
