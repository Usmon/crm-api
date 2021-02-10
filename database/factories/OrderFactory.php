<?php

namespace Database\Factories;

use App\Models\FedexOrder;
use App\Models\Order;
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


        return [
            'staff_id' => $usersId->random(),

            'fedex_order_id' => $fedexOrdersId->random(),

            'pickup_id' => $pickupsId->random(),

            'shipment_id' => $shipmentsId->random(),

            'sender_id' => $sender->random(),

            'recipient_id' => $recipient->random(),

            'status_id' => $status->random(),

            'payment_status_id' => $payment_status->random(),

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
