<?php

namespace Database\Factories;

use App\Models\Shipment;
use App\Models\User;
use App\Models\WarehouseItem;

use Illuminate\Database\Eloquent\Factories\Factory;

final class WarehouseItemFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = WarehouseItem::class;

    /**
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        $customers = User::all();

        $shipments = Shipment::all();

        return [
            'customer_id' => $customers->random(),

            'shipment_id' => $shipments->random(),

            'name' => $this->faker->name,

            'init_quantity' => random_int(0,10),

            'quantity' => random_int(0,10),

            'init_weight' => random_int(10,100)/10,

            'weight' => random_int(10,100)/10,

            'total_price' => random_int(10,100)/10,

            'payed' => random_int(10,100)/10,

            'note' => $this->faker->text
        ];
    }
}
