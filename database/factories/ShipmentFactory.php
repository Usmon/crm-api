<?php

namespace Database\Factories;

use App\Models\Box;

use App\Models\User;

use App\Models\Status;

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
        $users = User::all();

        $statuses = Status::all();

        return [
            'name' => $this->faker->slug(5),

            'creator_id' => $users->random(),

            'status_id' => $statuses->random(),
        ];
    }
}
