<?php

namespace Database\Factories;

use App\Models\Order;

use App\Models\User;

use App\Models\OrderComment;

use Illuminate\Database\Eloquent\Factories\Factory;

final class OrderCommentFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = OrderComment::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $orders = Order::all();

        $users = User::all();

        return [
            'order_id' => $orders->random(),

            'owner_id' => $users->random(),

            'comment' => $this->faker->text()
        ];
    }
}
