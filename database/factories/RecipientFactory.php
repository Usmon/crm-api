<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Recipient;

use Illuminate\Database\Eloquent\Factories\Factory;

final class RecipientFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Recipient::class;

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
