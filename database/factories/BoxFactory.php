<?php

namespace Database\Factories;

use App\Models\Box;

use App\Models\Order;

use App\Models\Pickup;

use App\Models\Shipment;
use App\Models\User;

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
     * @throws \Exception
     */
    public function definition(): array
    {
        $pickups = Pickup::all();

        $orders = Order::all();

        $statuses = Status::where('model', StatusService::ORDER)->get(['id']);

        $deliveryId = [Delivery::all()->random(), null];

        $shipmentId = [Shipment::all()->random(), null];

        $users = User::all();

        return [
            'pickup_id' => $pickups->random(),

            'order_id' => $orders->random(),

            'note' => $this->faker->text(100),

            'weight' => $this->faker->randomFloat(2, 100, 1000),

            'additional_weight' => $this->faker->randomFloat(2, 100, 1000),

            'status_id' => $statuses->random(),

            'delivery_id' => $deliveryId[random_int(0,1)],

            'shipment_id' => $shipmentId[random_int(0,1)],

            'creator_id' => $users->random(),
        ];
    }
}
