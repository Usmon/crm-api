<?php

namespace Database\Factories;

use App\Models\Delivery;

use App\Models\User;

use App\Models\Order;

use Illuminate\Database\Eloquent\Factories\Factory;

final class DeliveryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Delivery::class;

    /**
     * @return array
     *
     */
    public function definition(): array
    {
        $status = ['pending', 'delivering', 'delivered'];
        $usersId = User::all(['id']);
        $ordersId = Order::all(['id']);

        return [
            'order_id' => $ordersId->random(),
            'driver_id' => $usersId->random(),
            'status' => $status[random_int(0,2)]
        ];
    }
}
