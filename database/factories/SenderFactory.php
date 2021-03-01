<?php

namespace Database\Factories;

use App\Models\City;

use App\Models\Region;

use App\Models\Sender;

use App\Models\Address;

use App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

final class SenderFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Sender::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $customers = Customer::all();

        return [
            'customer_id' => $customers->random(),
        ];
    }
}
