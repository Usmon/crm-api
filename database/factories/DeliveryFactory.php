<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Status;

use App\Models\Customer;

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

        $statues = Status::all();

        $customers = Customer::all();

        return [
            'customer_id' => $customers->random(),

            'driver_id' => $users->random(),

            'status_id' => $statues->random(),
        ];
    }
}
