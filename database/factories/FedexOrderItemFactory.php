<?php

namespace Database\Factories;

use App\Models\FedexOrder;
use App\Models\FedexOrderItem;

use Illuminate\Database\Eloquent\Factories\Factory;

final class FedexOrderItemFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = FedexOrderItem::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $fedexOrders = FedexOrder::all();

        return [
            'fedex_order_id' => $fedexOrders->random(),

            'weight' => $this->faker->numberBetween(100,1000)/100,

            'width' => $this->faker->numberBetween(10,1000),

            'height' => $this->faker->numberBetween(10,1000),

            'length' => $this->faker->numberBetween(10,1000),

            'service_price' => $this->faker->numberBetween(100,1000)/100,

            'label_file_name' => $this->faker->text,

            'barcode' => $this->faker->currencyCode
        ];
    }
}
