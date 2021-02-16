<?php

namespace Database\Seeders;

use App\Models\Pickup;
use App\Models\Status;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class StatusSeeder extends Seeder
{
    /**
     * @var array
     */
    private static $order = [
        [
            'value' => 'Created',
            'parameters' => [
                'color' => [
                    'bg' => '#FEF3EF',
                    'text' => '#EAA78D'
                ]
            ]
        ],
        [
            'value' => 'At the office',
            'parameters' => [
                'color' => [
                    'bg' => '#F6E9ED',
                    'text' => '#C06C84'
                ]
            ]
        ],
        [
            'value' => 'Shipment',
            'parameters' => [
                'color' => [
                    'bg' => '#F8EDE2',
                    'text' => '#F8EDE2'
                ]
            ]
        ],
        [
            'value' => 'Transit',
            'parameters' => [
                'color' => [
                    'bg' => '#E9E6EB',
                    'text' => '#E9E6EB'
                ]
            ]
        ],
        [
            'value' => 'Customs',
            'parameters' => [
                'color' => [
                    'bg' => '#E1E7EC',
                    'text' => '#355C7D'
                ]
            ]
        ],
        [
            'value' => 'Tashkent',
            'parameters' => [
                'color' => [
                    'bg' => '#DCECEB',
                    'text' => '#52A19B'
                ]
            ]
        ],
        [
            'value' => 'Delivering',
            'parameters' => [
                'color' => [
                    'bg' => '#DDF8F7',
                    'text' => '#1FCECB'
                ]
            ]
        ],
        [
            'value' => 'Delivered',
            'parameters' => [
                'color' => [
                    'bg' => '#DDF9F1',
                    'text' => '#1CD3A1'
                ]
            ]
        ],
    ];

    /**
     * @var array
     */
    public static $order_payment = [
        [
          'value' =>  'Paid',
          'parameters' => [
            'color' => [
                'bg' => '#DDF7ED',
                'text' => '#1BC585'
            ]
           ]
        ],
        [
          'value' => 'Debt',
          'parameters' => [
              'color' => [
                'bg' => '#FEEAEC',
                'text' => '#FEEAEC'
            ]
          ]
        ],
    ];


    public static $pickup = [
        [
            'value' => 'Pending',

            'parameters' => [
                'color' => [
                    'bg' => '#FFAA00',

                    'text' => 'Pending'
                ]
            ]
        ],

        [
            'value' => 'On the road',

            'parameters' => [
                'color' => [
                    'bg' => '#1FCECB',

                    'text' => 'On the road'
                ]
            ]
        ],

        [
            'value' => 'At the office',

            'parameters' => [
                'color' => [
                    'bg' => '#1CD3A1',

                    'text' => 'At the office'
                ]
            ]
        ]
    ];
    /**
     * @return void
     */
    public function run(): void
    {
        $this->createStatusesForModel(self::$order_payment, 'OrderPayment');

        $this->createStatusesForModel(self::$order, Order::class);

        $this->createStatusesForModel(self::$pickup, Pickup::class);
    }

    /**
     * @param array $items
     *
     * @param string $model_key
     */
    public function createStatusesForModel(array $items, string $model_key): void
    {
        foreach ($items as $index => $item) {
            $item['model'] = $model_key;

            $item['key'] = Str::slug($item['value']);

            $item['parameters'] = json_encode($item['parameters']);

            Status::create($item);
        }
    }
}
