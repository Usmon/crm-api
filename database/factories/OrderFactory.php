<?php

namespace Database\Factories;

use App\Models\FedexOrder;
use App\Models\Order;
use App\Models\PaymentType;
use App\Models\Sender;
use App\Models\Recipient;
use App\Models\Pickup;
use App\Models\Shipment;
use App\Models\User;
use App\Models\Status;
use App\Logic\Dashboard\CRUD\Services\Statuses as StatusService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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

        $sender = Sender::all(['id']);

        $recipient = Recipient::all(['id']);

        $status = Status::where('model', StatusService::ORDER)->get(['id']);

        $payment_status = Status::where('model', StatusService::ORDER_PAYMENT)->get(['id']);

        $payment_types = PaymentType::all('id');


        return [
            'staff_id' => $usersId->random(),

            'fedex_order_id' => $fedexOrdersId->random(),

            'pickup_id' => $pickupsId->random(),

            'shipment_id' => $shipmentsId->random(),

            'sender_id' => $sender->random(),

            'recipient_id' => $recipient->random(),

            'status_id' => $status->random(),

            'payment_type_id' => $payment_types->random(),

            'payment_status_id' => $payment_status->random(),

            'price_insurance' => rand(100, 1000),

            'price_warehouse' => rand(100, 5000),

            'price_delivery' => rand(100, 5000),

            'price_total' => rand(100, 5000),

            'price_debt' => rand(100, 5000),

            'weight_rate' => rand(1, 10),

            'type' => json_encode([
                'index' => 'pickup',

                'date' => [
                    'from' => now(),

                    'to' => now()->addSeconds(3600)
                ]
            ]),

            'price' => random_int(100,10000)/100,

            'payed_price' => random_int(100,10000)/100,
        ];
    }
}
