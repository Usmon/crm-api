<?php

namespace Database\Factories;

use App\Models\Status;

use App\Models\User;

use App\Models\Driver;

use App\Models\Customer;

use App\Models\Pickup;

use App\Logic\Dashboard\CRUD\Services\Statuses as StatusService;

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

        $statuses = Status::where('model', StatusService::PICKUP)->get(['id']);

        $pickupDatetimeStart = $this->faker->dateTimeThisYear('+1 month');

        $pickupDatetimeEnd   = strtotime('+1 Week', $pickupDatetimeStart->getTimestamp());

        return [
            'pickup_datetime_start' => $pickupDatetimeStart,

            'pickup_datetime_end' => $pickupDatetimeEnd,

            'status_id' => $statuses->random(),

            'customer_id' => $customers->random(),

            'driver_id' => $drivers->random(),

            'creator_id' => $users->random(),
        ];
    }
}
