<?php

namespace Database\Factories;

use App\Models\Order;

use App\Models\OrderHistory;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

final class OrderHistoryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = OrderHistory::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $orders = Order::all(['id']);

        $users = User::all(['id']);

        return [
            'creator_id' => $users->random(),

            'order_id' => $orders->random(),

            'seq' => rand(1, 15)
        ];
    }
}
