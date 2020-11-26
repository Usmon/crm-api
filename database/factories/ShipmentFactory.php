<?php

namespace Database\Factories;

use App\Models\Shipment;

use Illuminate\Database\Eloquent\Factories\Factory;

final class ShipmentFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Shipment::class;

    /**
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        $status = ['pending', 'shipping', 'shipped'];
        return [
            'name' => $this->faker->text(),
            'status' => $status[random_int(0,2)]
        ];
    }
}
