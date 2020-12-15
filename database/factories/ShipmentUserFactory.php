<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Shipment;

use App\Models\ShipmentUser;

use Illuminate\Database\Eloquent\Factories\Factory;

final class ShipmentUserFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = ShipmentUser::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        $shipments = Shipment::all();

        return [
            'user_id' => $users->random(),

            'shipment_id' => $shipments->random()
        ];
    }
}
