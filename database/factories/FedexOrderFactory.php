<?php

namespace Database\Factories;

use App\Models\FedexOrder;

use App\Models\User;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\Factory;

final class FedexOrderFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = FedexOrder::class;

    /**
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        $users = User::all();
        return [
            'price' => $this->faker->randomFloat(2, 100, 1000),

            'discount_price' => $this->faker->randomFloat(2, 100, 1000),

            'staff_id' => $users->random(),

            'customer_id' => $users->random(),

            'arrived_at' => Carbon::now()->subDays(random_int(3,10)),
        ];
    }
}
