<?php

namespace Database\Factories;

use App\Models\ShipmentStatus;

use Illuminate\Database\Eloquent\Factories\Factory;

final class ShipmentStatusFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = ShipmentStatus::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => substr($this->faker->unique()->slug,0,5)
        ];
    }
}
