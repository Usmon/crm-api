<?php

namespace Database\Factories;

use App\Models\Box;

use App\Models\Order;

use App\Models\Status;

use App\Models\Delivery;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Logic\Dashboard\CRUD\Services\Statuses as StatusService;

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
        $ordersId = Order::all(['id']);

        $status = Status::where('model', StatusService::ORDER)->get(['id']);

        $deliveryId = [Delivery::all()->random(), null];

        return [
            'order_id' => $ordersId->random(),

            'weight' => $this->faker->randomFloat(2, 100, 1000),

            'additional_weight' => $this->faker->randomFloat(2, 100, 1000),

            'status_id' => $status->random(),

            'delivery_id' => $deliveryId[random_int(0,1)],
        ];
    }
}
