<?php

namespace Database\Factories;

use App\Models\Address;

use App\Models\City;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

final class AddressFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Address::class;

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function definition(): array
    {
        $users = User::all();

        $cities = City::all();

        return [
            'user_id' => $users->random(),

            'city_id' => $cities->random(),

            'first_address' => $this->faker->address,

            'second_address' => $this->faker->address,
        ];
    }
}
