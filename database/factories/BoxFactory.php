<?php

namespace Database\Factories;

use App\Models\Order;

use App\Models\Sender;

use App\Models\Recipient;

use App\Models\User;

use App\Models\Box;

use Illuminate\Database\Eloquent\Factories\Factory;

final class BoxFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Box::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $status = ['pending', 'waiting'];
        $usersId = User::all(['id']);
        $ordersId = Order::all(['id']);
        $senderId = Sender::all(['id']);
        $recipientId = Recipient::all(['id']);

        return [
            'order_id' => $ordersId->random(),

            'customer_id' => $usersId->random(),

            'sender_id' => $senderId->random(),

            'recipient_id' => $recipientId->random(),

            'weight' => $this->faker->randomFloat(2, 100, 1000),

            'additional_weight' => $this->faker->randomFloat(2, 100, 1000),

            'status' => $status[random(0,1)],

            'box_image' => $this->faker->text(),
        ];
    }
}
