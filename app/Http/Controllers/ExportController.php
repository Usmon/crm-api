<?php

namespace App\Http\Controllers;

use App\Helpers\Json;
use App\Models\Box;

use App\Models\BoxItem;

use App\Models\Shipment;

use App\Http\Requests\Export;

use Spatie\ArrayToXml\ArrayToXml;

/**
 * Class ExportController
 *
 * @package App\Http\Controllers
 */
class ExportController extends Controller
{
    /**
     * @param Export $request
     *
     * @return mixed
     */
    public function boxes(Export $request)
    {
        $id = $request->get('id') ?? $request->json('id');

        $boxes = Box::whereIn('id', $id)->get();

        $data = $boxes->transform(function (Box $box) {
            return [
                'decl_type' => 1,

                'ident_num' => $box->id,

                'ident_data' => '',

                'sending_country' => 840,

                'receiving_country' => 860,

                'total_cost' => $box->total_price,

                'brutto' => $box->total_weight,

                'company_inn' => 303027872,

                'type_firm' => 1,

                'nakl_num' => $box->id,

                'kkdg' => '',

                'receiver_inn' => '',

                'last_name' => $box->order->recipient->customer->user->split_name['last_name'],

                'first_name' => $box->order->recipient->customer->user->split_name['first_name'],

                'father_name' => $box->order->recipient->customer->user->split_name['middle_name'],

                'citizen' => '860',

                'pass_ser' => $box->order->recipient->customer->passport_serialize['serial'],

                'pass_num' => $box->order->recipient->customer->passport_serialize['number'],

                'region' => $box->order->recipient->customer->user->addresses()->first()->city->region_id,

                'district' => $box->order->recipient->customer->user->addresses()->first()->city_id,

                'address' => $box->order->recipient->customer->user->addresses()->first()->first_address,

                'internet' => '0',

                'ConsignmentItem' => $box->items->transform(function(BoxItem $boxItem, int $index) {
                    return [
                        'number' => ++$index,

                        'name' => $boxItem->name,

                        'unit' => 796,

                        'tiftn' => '',

                        'quantity' => $boxItem->quantity,

                        'netto' => $boxItem->weight,

                        'currency' => 796,

                        'cost' => $boxItem->price
                    ];
                })->toArray()

            ];
        });

        $result = ArrayToXml::convert(['Declaration' => $data->toArray()], [
            'rootElementName' => 'main_data'
        ]);

        return response($result, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    public function shipmentDeclaration(Export $request)
    {
        $id = $request->json('id') ?? $request->get('id');

        $shipment = Shipment::find($id);

        $result = $shipment->boxes->transform(function (Box $box) {
            $recipient_address = $box->order->recipient->customer->user->addresses()->with(['city.region.country'])->first();

            $sender_address = $box->order->sender->customer->user->addresses()->with(['city.region.country'])->first();

            return [
                'agent_code' => $box->id,

                'sender' => [
                    'full_name' => $box->order->sender->customer->user->full_name,

                    'address' => [

                        'country' => $sender_address->city->region->country->name,

                        'region' => $sender_address->city->region->name,

                        'city' => $sender_address->city->name,

                        'first_address' => $sender_address->first_address,

                        'second_address' => $sender_address->second_address,
                    ],

                    'phone' => $box->order->sender->customer->user->phones()->first()->phone
                ],

                'recipient' => [
                    'full_name' => $box->order->recipient->customer->user->full_name,

                    'passport' => $box->order->recipient->customer->passport,

                    'address' => [

                        'country' => $recipient_address->city->region->country->name,

                        'region' => $recipient_address->city->region->name,

                        'city' => $recipient_address->city->name,

                        'first_address' => $recipient_address->first_address,

                        'second_address' => $recipient_address->second_address,
                    ],

                    'phone' => $box->order->recipient->customer->user->phones()->first()->phone
                ],

                'weight' => $box->weight,

                'products' => $box->items->transform(function(BoxItem $boxItem) {
                    return [
                        'name' => $boxItem->name,

                        'quantity' => $boxItem->quantity,

                        'price' => $boxItem->price,

                        'type_weight' => $boxItem->type_weight,

                        'made_in' => $boxItem->made_in,
                    ];
                }),


            ];
        });

        return Json::sendJsonWith200([
            'pages' => $result
        ]);
    }
}
