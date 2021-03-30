<?php

namespace Database\Factories;

use App\Models\Customer;

use App\Models\Recipient;

use Illuminate\Database\Eloquent\Factories\Factory;

final class RecipientFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Recipient::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $users = Customer::all();

        return [
            'customer_id' => $users->random(),
        ];
    }
}
