<?php

namespace App\Http\Controllers\Dashboard\FedexOrders;

use App\Helpers\Json;

use App\Models\Sender;

use App\Models\FedexOrder;

use App\Http\Controllers\Controller as Controllers;

use App\Logic\Dashboard\CRUD\Requests\FedexOrders as FedexOrdersRequest;

use App\Logic\Dashboard\CRUD\Services\FedexOrders as FedexOrdersService;

use App\Logic\Dashboard\CRUD\Repositories\FedexOrders as FedexOrdersRepository;

use Illuminate\Http\JsonResponse;

use App\Integrations\Fedex\Rate as FedexRate;

use App\Integrations\Fedex\Ship as FedexShip;

use Illuminate\Support\Facades\Storage;

final class Controller extends Controllers
{
    /**
     * @var FedexOrdersService
     */
    protected $service;

    /**
     * @var FedexOrdersRepository
     */
    protected $repository;

    /**
     * Controller constructor.
     *
     * @param FedexOrdersService $service
     *
     * @param FedexOrdersRepository $repository
     */
    public function __construct(FedexOrdersService $service, FedexOrdersRepository $repository)
    {
        $this->service = $service;

        $this->repository = $repository;
    }

    /**
     * @param FedexOrdersRequest $request
     * @return JsonResponse
     */
    public function index(FedexOrdersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'filters' => $this->service->getAllFilters($request),

            'fedex-orders' => $this->service->getFedexOrders($this->repository->getFedexOrders($this->service->getOnlyFilters($request))),
        ]);
    }

    /**
     * @param FedexOrdersRequest $request
     * @return JsonResponse
     */
    public function store(FedexOrdersRequest $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The fedex-order was successfully created.',

            'fedex-order' => $this->repository->storeFedexOrder($this->service->storeCredentials($request)),
        ]);
    }

    /**
     * @param FedexOrder $fedexOrder
     * @return JsonResponse
     */
    public function show(FedexOrder $order): JsonResponse
    {
        return Json::sendJsonWith200([
            'fedex-order' => $this->service->showFedexOrder($order),
        ]);
    }

    /**
     * @param FedexOrdersRequest $request
     * @param FedexOrder $fedexOrder
     * @return JsonResponse
     */
    public function update(FedexOrdersRequest $request, FedexOrder $fedexOrder): JsonResponse
    {
        return Json::sendJsonWith200([
            'message' => 'The fedex-order was successfully updated.',

            'fedex-order' => $this->repository->updateFedexOrder($fedexOrder, $this->service->updateCredentials($request)),
        ]);
    }

    /**
     * @param FedexOrder $fedexOrder
     * @return JsonResponse
     */
    public function destroy(FedexOrder $fedexOrder): JsonResponse
    {
        if (! $this->repository->deleteFedexOrder($fedexOrder)) {
            return Json::sendJsonWith409([
                'message' => 'Failed to delete fedex-order, please try again later.',
            ]);
        }

        return Json::sendJsonWith200([
            'message' => 'The fedex-order was successfully deleted.',
        ]);
    }

    /**
     * @param FedexOrdersRequest $request
     *
     * @return JsonResponse
     */
    public function rate(FedexOrdersRequest $request): JsonResponse
    {
        //@TODO Need code refactoring

        //Prepare data
        $sender = Sender::findOrFail($request->json('sender_id'));

        $address = $sender->customer->user->addresses()->first();

        $request_data = [
            "shipper" => [
                "contact" => [
                    "name" => $address->user->full_name,
                    "company" => "Silkroad",
                    "phone" => $address->user->phones->first()->phone,
                ],
                "address" => [
                    "streetLines" => [
                        $address->first_address,
                        $address->second_address
                    ],
                    "city" => $address->city->name,
                    "provinceCode" => $address->city->region->code,
                    "postalCode" => $address->city->codes[0]
                ]
            ],
            "packages" => $request->json('boxes')
        ];

        $fedex_request = new FedexRate();

        $resp = $fedex_request->getResult($request_data);

        if ($result = $resp['RateReplyDetails']) {
            $result = collect($result);
        }

        return Json::sendJsonWith200([
            'rates' => $result->transform(function (array $item) {
                return [
                    'service_type' => $item['ServiceType'],

                    'title' => ucfirst(strtolower(str_replace('_', ' ', $item['ServiceType']))),

                    'price' => $item['RatedShipmentDetails'][0]['ShipmentRateDetail']['TotalNetFedExCharge'],

                    'freight_price' => $item['RatedShipmentDetails'][0]['ShipmentRateDetail']['TotalNetFreight'],
                ];
            })->toArray()
        ]);
    }

    /**
     * @param FedexOrdersRequest $request
     *
     * @return JsonResponse
     */
    public function ship(FedexOrdersRequest $request): JsonResponse
    {
        //@TODO Need code refactoring

        //Prepare data
        $sender = Sender::findOrFail($request->json('sender_id'));

        $address = $sender->customer->user->addresses()->first();

        $boxes = $request->json('boxes');

        $request_data = [
            "shipper" => [
                "contact" => [
                    "name" => $address->user->full_name,
                    "company" => "Silkroad",
                    "phone" => $address->user->phones->first()->phone,
                ],
                "address" => [
                    "streetLines" => [
                        $address->first_address,
                        $address->second_address
                    ],
                    "city" => $address->city->name,
                    "provinceCode" => $address->city->region->code,
                    "postalCode" => $address->city->codes[0]
                ]
            ]
        ];

        $box_items = [];

        foreach ($boxes as $box) {
            $request_data['packages'] = [$box];

            $fedex_request = new FedexShip();

            $resp = $fedex_request->getResult($request_data);

            if ($resp['HighestSeverity'] === 'SUCCESS') {
                $decoded = $resp['CompletedShipmentDetail']['CompletedPackageDetails'][0]['Label']['Parts'][0]['Image'];

                $file_name = 'files/'. md5(time()).'.pdf';

                Storage::disk('s3')->put($file_name, base64_decode($decoded).'pdf');

                $url_to_file = Storage::disk('s3')->url($file_name);

                $box_items[] = [
                    'tracking_number' => $resp['CompletedShipmentDetail']['MasterTrackingId']['TrackingNumber'],

                    'service_price' => $resp['CompletedShipmentDetail']['ShipmentRating']['ShipmentRateDetails'][0]['TotalNetFedExCharge']['Amount'],

                    'service_discount_price' => $resp['CompletedShipmentDetail']['ShipmentRating']['ShipmentRateDetails'][0]['TotalNetFreight']['Amount'],

                    'label_file_name' => $url_to_file,

                    'barcode' => $resp['CompletedShipmentDetail']['CompletedPackageDetails'][0]['OperationalDetail']['Barcodes']['StringBarcodes'][0]['Value'],

                    'weight' => $box['weight']['value']
                ];
            }

            //Sleep please 1 moment
            sleep(1);
        }

        $prices = collect($box_items);

        $order = FedexOrder::create([
            'price' => $prices->sum('service_price'),

            'discount_price' => $prices->sum('service_discount_price'),

            'customer_id' => $sender->customer_id
        ]);

        $order->items()->createMany($box_items);

        $order->items;

        return Json::sendJsonWith200([
            'fedex_order' => $order
        ]);
    }
}
