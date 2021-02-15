<?php

namespace Database\Factories;

use App\Models\City;

use App\Models\User;

use App\Models\Region;

use App\Models\Driver;

use App\Models\Address;

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

        $region = Region::all(['id'])->random(1)->first();

        $city = City::where('id', $region->id)->get(['id'])->random(1)->first();

        $address = Address::where('id',$city->id)->first(['id']);

        return [
            'creator_id' => $users->random(),

            'user_id' => $users->random(),

            'region_id' => $region,

            'city_id' => $city,

            'address_id' => $address,

            'car_model' => $carModels[random_int(0, sizeof($carModels)-1)],

            'car_number' => $carNumbers[random_int(0, sizeof($carNumbers)-1)],
        ];
    }
}
