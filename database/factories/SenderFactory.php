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

        $region = Region::all(['id'])->random(1)->first();

        $city = City::where('id', $region->id)->get(['id'])->random(1)->first();

        $address = Address::where('id',$city->id)->first(['id']);

        return [
            'customer_id' => $customers->random(),

            'region_id' => $region,

            'city_id' => $city,

            'address_id' => $address,
        ];
    }
}
