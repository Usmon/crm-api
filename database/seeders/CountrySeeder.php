<?php

namespace Database\Seeders;

use App\Models\Country;

use App\Models\Region;

use App\Models\City;

use Illuminate\Database\Seeder;

final class CountrySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->createCountry(include('countries/usa.php'));

        $this->createCountry(include('countries/uzb.php'));
    }

    /**
     * @param array $country_data
     *
     * @return void
     */
    public function createCountry(array $country_data): void
    {
            $country = Country::create([
                'name' => $country_data['name'],

                'code' => $country_data['code']
            ]);

            foreach($country_data['regions'] as $region_code => $region_item) {
                $region = Region::create([
                    'country_id' => $country->id,

                    'name' => $region_item['name'],

                    'code' => $region_code,

                    'zip_code' => (is_int(array_key_first($region_item['cities']))) ? array_key_first($region_item['cities']) : null
                ]);

                foreach ($region_item['cities'] as $city_name => $codes) {
                    City::create([
                        'region_id' => $region->id,

                        'name' => $city_name,

                        'codes' => $codes
                    ]);
                }
            }
    }
}
