<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Phone;

use Illuminate\Database\Eloquent\Factories\Factory;

final class PhoneFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Phone::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        return [
            'user_id' => $users->random(),

            'phone' => $this->faker->phoneNumber,
        ];
    }
}
