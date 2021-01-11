<?php

namespace Database\Factories;

use App\Models\User;

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
     *@return array
     *
     * @throws \Exception
     */
    public function definition(): array
    {
        $status = ['pending', 'delivering', 'delivered'];

        $users = User::all();

        $customers = Customer::all();

        return [
            'customer_id' => $customers->random(),

            'driver_id' => $users->random(),

            'status' => $status[random_int(0,2)]
        ];
    }
}
