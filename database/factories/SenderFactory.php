<?php

namespace Database\Factories;

use App\Models\Sender;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class SenderFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Sender::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        return [
            'customer_id' => $users->random(),

            'address' => $this->faker->address
        ];
    }
}
