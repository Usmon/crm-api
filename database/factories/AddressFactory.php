<?php

namespace Database\Factories;

use App\Models\Address;

use App\Models\Customer;

use App\Models\City;

use Illuminate\Database\Eloquent\Factories\Factory;

final class AddressFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Address::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $customers = Customer::all();



        return [
            'customer_id' => $customers->random(),

            'city_id' => random_int(1,65),

            'first_address' => $this->faker->address,

            'second_address' => $this->faker->address,
        ];
    }
}
