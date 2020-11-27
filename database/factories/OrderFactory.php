<?php

namespace Database\Factories;

use App\Models\FedexOrder;
use App\Models\Order;

use App\Models\Pickup;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class OrderFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Order::class;

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function definition(): array
    {
        $usersId = User::all(['id']);

        $fedexOrdersId = FedexOrder::all(['id']);

        $pickupsId = Pickup::all(['id']);

        $shipmentsId = Shipment::all(['id']);

        $status = ['created','picked_up','waiting','pending','shipping','shipped','delivering','delivered','canceled'];

        $payment_status = ['payed', 'debt'];


        return [
            'staff_id' => $usersId->random(),

            'customer_id' => $usersId->random(),

            'fedex_order_id' => $fedexOrdersId->random(),

            'pickup_id' => $pickupsId->random(),

            'shipment_id' => $shipmentsId->random(),

            'price' => random_int(100,10000)/100,

            'payed_price' => random_int(100,10000)/100,

            'status' => collect($status)->random(),

            'payment_status' => collect($payment_status)->random(),
        ];
    }
}
