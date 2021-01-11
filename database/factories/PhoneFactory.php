<?php

namespace Database\Factories;

use App\Models\Phone;

use App\Models\Customer;

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
        $customers = Customer::all();

        return [
            'customer_id' => $customers->random(),

            'phone' => $this->faker->phoneNumber,
        ];
    }
}
