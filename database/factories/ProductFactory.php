<?php

namespace Database\Factories;

use App\Models\Order;

use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

final class ProductFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Product::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $orders = Order::all();

        $statuses = Product::STATUSES;

        $type_weight = ['lb','kg'];

        return [
            'order_id' => $orders->random(),

            'name' => $this->faker->slug,

            'status' => $statuses[random_int(0, count($statuses)-1)],

            'quantity' => random_int(1,6),

            'price' => random_int(10000,100000)/100,

            'weight' => random_int(100,1000)/100,

            'type_weight' => $type_weight[random_int(0,1)],
        ];
    }
}
