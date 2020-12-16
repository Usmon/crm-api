<?php

namespace Database\Factories;

use App\Models\User;

use App\Models\Customer;

use Illuminate\Support\Facades\Date;

use Illuminate\Database\Eloquent\Factories\Factory;

final class CustomerFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Customer::class;

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function definition(): array
    {
        $users = User::all();

        return [
            'user_id' => $users->random(),

            'creator_id' => $users->random(),

            'passport' => $this->faker->text(),

            'birth_date' => Date::create(random_int(1950,2000), random_int(1,12), random_int(1,27)),

            'note' => $this->faker->text,
        ];
    }
}
