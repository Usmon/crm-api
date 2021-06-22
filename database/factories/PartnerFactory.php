<?php

namespace Database\Factories;

use App\Models\Partner;

use App\Models\City;

use Illuminate\Database\Eloquent\Factories\Factory;

final class PartnerFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Partner::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $cities = City::all('id');

        return [
            'city_id' => $cities->random(),

            'name' => $this->faker->company(),

            'phone' => $this->faker->tollFreePhoneNumber(),

            'address' => $this->faker->address(),

            'description' => $this->faker->text(30)
        ];
    }
}
