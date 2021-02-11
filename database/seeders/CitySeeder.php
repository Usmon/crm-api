<?php

namespace Database\Seeders;

use App\Models\City;

use Illuminate\Support\Carbon;

use Illuminate\Database\Seeder;

final class CitySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $states = [
            ['created_at'=>Carbon::now(),'name' => 'Alaska'],
            ['created_at'=>Carbon::now(),'name' => 'Alabama'],
            ['created_at'=>Carbon::now(),'name' => 'Arkansas'],
            ['created_at'=>Carbon::now(),'name' => 'Arizona'],
            ['created_at'=>Carbon::now(),'name' => 'California'],
            ['created_at'=>Carbon::now(),'name' => 'Colorado'],
            ['created_at'=>Carbon::now(),'name' => 'Connecticut'],
            ['created_at'=>Carbon::now(),'name' => 'District of Columbia'],
            ['created_at'=>Carbon::now(),'name' => 'Delaware'],
            ['created_at'=>Carbon::now(),'name' => 'Florida'],
            ['created_at'=>Carbon::now(),'name' => 'Georgia'],
            ['created_at'=>Carbon::now(),'name' => 'Hawaii'],
            ['created_at'=>Carbon::now(),'name' => 'Iowa'],
            ['created_at'=>Carbon::now(),'name' => 'Idaho'],
            ['created_at'=>Carbon::now(),'name' => 'Illinois'],
            ['created_at'=>Carbon::now(),'name' => 'Indiana'],
            ['created_at'=>Carbon::now(),'name' => 'Kansas'],
            ['created_at'=>Carbon::now(),'name' => 'Kentucky'],
            ['created_at'=>Carbon::now(),'name' => 'Louisiana'],
            ['created_at'=>Carbon::now(),'name' => 'Massachusetts'],
            ['created_at'=>Carbon::now(),'name' => 'Maryland'],
            ['created_at'=>Carbon::now(),'name' => 'Maine'],
            ['created_at'=>Carbon::now(),'name' => 'Michigan'],
            ['created_at'=>Carbon::now(),'name' => 'Minnesota'],
            ['created_at'=>Carbon::now(),'name' => 'Missouri'],
            ['created_at'=>Carbon::now(),'name' => 'Mississippi'],
            ['created_at'=>Carbon::now(),'name' => 'Montana'],
            ['created_at'=>Carbon::now(),'name' => 'North Carolina'],
            ['created_at'=>Carbon::now(),'name' => 'North Dakota'],
            ['created_at'=>Carbon::now(),'name' => 'Nebraska'],
            ['created_at'=>Carbon::now(),'name' => 'New Hampshire'],
            ['created_at'=>Carbon::now(),'name' => 'New Jersey'],
            ['created_at'=>Carbon::now(),'name' => 'New Mexico'],
            ['created_at'=>Carbon::now(),'name' => 'Nevada'],
            ['created_at'=>Carbon::now(),'name' => 'New York'],
            ['created_at'=>Carbon::now(),'name' => 'Ohio'],
            ['created_at'=>Carbon::now(),'name' => 'Oklahoma'],
            ['created_at'=>Carbon::now(),'name' => 'Oregon'],
            ['created_at'=>Carbon::now(),'name' => 'Pennsylvania'],
            ['created_at'=>Carbon::now(),'name' => 'Rhode Island'],
            ['created_at'=>Carbon::now(),'name' => 'South Carolina'],
            ['created_at'=>Carbon::now(),'name' => 'South Dakota'],
            ['created_at'=>Carbon::now(),'name' => 'Tennessee'],
            ['created_at'=>Carbon::now(),'name' => 'Texas'],
            ['created_at'=>Carbon::now(),'name' => 'Utah'],
            ['created_at'=>Carbon::now(),'name' => 'Virginia'],
            ['created_at'=>Carbon::now(),'name' => 'Vermont'],
            ['created_at'=>Carbon::now(),'name' => 'Washington'],
            ['created_at'=>Carbon::now(),'name' => 'Wisconsin'],
            ['created_at'=>Carbon::now(),'name' => 'West Virginia'],
            ['created_at'=>Carbon::now(),'name' => 'Wyoming'],
            ['created_at'=>Carbon::now(),'name' => 'Qoraqalpog‘iston Respublikasi'],
            ['created_at'=>Carbon::now(),'name' => 'Andijon viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Buxoro viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Jizzax viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Qashqadaryo viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Navoiy viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Namangan viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Samarqand viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Surxandaryo viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Sirdaryo viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Toshkent viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Farg‘ona viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Xorazm viloyati'],
            ['created_at'=>Carbon::now(),'name' => 'Toshkent shahri'],
        ];

        City::insert($states);
    }
}
