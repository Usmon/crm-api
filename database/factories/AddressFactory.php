<?php

namespace Database\Factories;

use App\Models\Address;

use App\Models\Customer;

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

            'address' => $this->faker->address,
        ];
    }
}
