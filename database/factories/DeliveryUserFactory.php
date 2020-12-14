<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Delivery;

use App\Models\DeliveryUser;

use Illuminate\Database\Eloquent\Factories\Factory;

final class DeliveryUserFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = DeliveryUser::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        $deliveries = Delivery::all();

        return [
            'user_id' => $users->random(),

            'delivery_id' => $deliveries->random()
        ];
    }
}
