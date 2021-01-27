<?php

namespace Database\Factories;

use App\Models\Driver;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class DriverFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Driver::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = User::all();

        $carModels = [
            'BMW',

            'Toyota',

            'Audi'
        ];

        $carNumbers = [
            'A 834 01 B',

            'B 834 01 N',

            'C 834 01 M',

            'D 834 01 C',

            'E 834 01 P',

            'F 834 01 O',

            'F 834 01 L',

            'H 834 01 W',

            'I 834 01 E',

            'J 834 01 R',

            'K 834 01 T',

            'L 834 01 F',
        ];

        return [
            'creator_id' => $users->random(),

            'name' => $this->faker->name,

            'phone' => $this->faker->phoneNumber,

            'email' => $this->faker->unique()->email,

            'region' => $this->faker->country,

            'city' => $this->faker->city,

            'zip_or_post_code' => $this->faker->postcode,

            'address' => $this->faker->address,

            'car_model' => $carModels[random_int(0, sizeof($carModels)-1)],

            'car_number' => $carNumbers[random_int(0, sizeof($carNumbers)-1)],
        ];
    }
}
