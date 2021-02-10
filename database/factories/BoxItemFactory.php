<?php

namespace Database\Factories;

use App\Models\Box;

use App\Models\WarehouseItem;

use App\Models\BoxItem;

use Illuminate\Database\Eloquent\Factories\Factory;

final class BoxItemFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = BoxItem::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $boxId = Box::all(['id']);

        return [
            'box_id' => $boxId->random(),

            'name' => $this->faker->text(12),

            'quantity' => 1,

            'price' => $this->faker->randomFloat(2,100,1000),

            'weight' => $this->faker->randomFloat(2,100,1000),

            'made_in' => $this->faker->text(20),

            'note' => $this->faker->text(),

            'is_additional' => 1,

        ];
    }
}
