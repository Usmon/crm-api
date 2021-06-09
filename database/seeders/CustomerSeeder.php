<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\City;
use App\Models\Customer;
use App\Models\Phone;
use App\Models\Sender;
use App\Models\User;
use Cassandra\Custom;
use Illuminate\Database\Seeder;

final class CustomerSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        if (config('app.env') == 'prod')
            $this->defaultCustomers();
        else
            Customer::factory()->times(15)->create();
    }

    /**
     *
     */
    public function defaultCustomers()
    {
        $path = storage_path() . "/json/";

        $customers = json_decode(file_get_contents($path.'customers.json'), true);

        foreach ($customers as $index => $customer) {
            if (!User::where('email', $customer['user']['email'])->first()) {
                if ($customer['user']['email'] == '' || $customer['user']['email'] == ' ' || $customer['user']['email'] == null)
                    $customer['user']['email'] = md5(time().$index).'@gmail.com';

                $user = User::factory()->create($customer['user']);
                $customer['customer']['passport'] = $customer['customer']['passport'] ?? ' ';
                $client = Customer::create(array_merge($customer['customer'], ['user_id' => $user->id, 'creator_id' => 1]));
                Sender::create(['customer_id' => $client->id]);

                foreach ($customer['addresses'] as $address) {
                    if ($address['is_recipient']) {
                        $recipient_user = User::factory()->create(['full_name' => $address['full_name']]);
                        $recipient_customer = Customer::create(['creator_id' => 1, 'user_id' => $recipient_user->id, 'passport' => $address['passport']]);
                        Sender::create(['customer_id' => $recipient_customer->id]);
                        foreach ($address['phones'] as $phone) {
                            Phone::create(['user_id' => $recipient_user->id, 'phone' => $phone]);
                        }

                        Address::create([
                            'user_id' => $recipient_user->id,
                            'first_address' => $address['first_address'],
                            'second_address' => $address['second_address'] ?? ' ',
                            'house' => $address['house'],
                            'apartment' => $address['apartment'],
                            'city_id' => $this->getCityId($address['zip_code'], $address['city'])
                        ]);
                    }
                    else {
                        Address::create([
                            'user_id' => $user->id,
                            'first_address' => $address['first_address'],
                            'second_address' => $address['second_address'] ?? ' ',
                            'house' => $address['house'],
                            'apartment' => $address['apartment'],
                            'city_id' => $this->getCityId($address['zip_code'], $address['city'])
                        ]);
                    }
                }
            }
        }
    }

    public function getCityId($zip_code, $city)
    {
        $city = City::where('name', 'like', '%'.$city.'%')->orWhere('codes', 'like', '%'.$zip_code.'%')->first();

        if ($city)
            return $city->id;

        return 1;
    }
}
