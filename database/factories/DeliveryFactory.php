<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\User;

use App\Models\Status;

use App\Models\Recipient;

use App\Models\Delivery;

use Illuminate\Database\Eloquent\Factories\Factory;

final class DeliveryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Delivery::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        $drivers = Driver::all();

        $statues = Status::all();

        $recipients = Recipient::all();

        return [
            'recipient_id' => $recipients->random(),

            'driver_id' => $drivers->random(),

            'status_id' => $statues->random(),

            'creator_id' => $users->random(),
        ];
    }
}
