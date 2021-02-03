<?php

namespace Database\Factories;

use App\Models\City;

use App\Models\Address;

use Illuminate\Database\Eloquent\Factories\Factory;

final class CityFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = City::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $address = Address::all();

        return [
            'address_id' => $address->random(),

            'name' => $this->faker->text(),
        ];
    }
}
