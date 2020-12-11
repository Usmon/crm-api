<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Delivery;

use App\Models\DeliveryComment;

use Illuminate\Database\Eloquent\Factories\Factory;

final class DeliveryCommentFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = DeliveryComment::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $deliveries = Delivery::all();

        $users = User::all();

        return [
            'delivery_id' => $deliveries->random(),

            'owner_id' => $users->random(),

            'comment' => $this->faker->text()
        ];
    }
}
