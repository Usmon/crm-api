<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderUser;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class OrderUserFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = OrderUser::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        $orders = Order::all();

        return [
            'user_id' => $users->random(),

            'order_id' => $orders->random()
        ];
    }
}
