<?php

namespace Database\Factories;

use App\Models\Order;

use App\Models\Sender;

use App\Models\Recipient;

use App\Models\User;

use App\Models\Box;

use App\Models\Status;

use App\Logic\Dashboard\CRUD\Services\Statuses as StatusService;

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
        $usersId = User::all(['id']);
        $ordersId = Order::all(['id']);
        $senderId = Sender::all(['id']);
        $recipientId = Recipient::all(['id']);
        $status = Status::where('model', StatusService::ORDER)->get(['id']);

        return [
            'order_id' => $ordersId->random(),

            'weight' => $this->faker->randomFloat(2, 100, 1000),

            'additional_weight' => $this->faker->randomFloat(2, 100, 1000),

            'status_id' => $status->random(),
        ];
    }
}
