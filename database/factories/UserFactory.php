<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Partner;

use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Factories\Factory;

final class UserFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = User::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'login' => $this->faker->unique()->userName,

            'email' => $this->faker->unique()->email,

            'password' => Hash::make('secret'),

            'profile' => [
                'first_name' => $this->faker->firstName,

                'middle_name' => $this->faker->lastName,

                'last_name' => $this->faker->lastName,

                'photo' => $this->faker->imageUrl(500, 500),
            ],

            'partner_id' => Partner::all('id')->random()
        ];
    }
}
