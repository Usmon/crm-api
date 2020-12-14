<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Shipment;

use App\Models\ShipmentComment;

use Illuminate\Database\Eloquent\Factories\Factory;

final class ShipmentCommentFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = ShipmentComment::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $shipments = Shipment::all();

        $users = User::all();

        return [
            'shipment_id' => $shipments->random(),

            'owner_id' => $users->random(),

            'comment' => $this->faker->text()
        ];
    }
}
