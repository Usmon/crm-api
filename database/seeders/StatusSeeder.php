<?php

namespace Database\Seeders;

use App\Models\Order;

use App\Models\Status;

use App\Models\Pickup;

use App\Models\Shipment;

use App\Models\Delivery;

use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

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
                    'text' => '#F8B195',
                    'bg' => '#f9bca4'
                ]
            ]
        ],
        [
            'value' => 'At the office',
            'parameters' => [
                'color' => [
                    'text' => '#C06C84',
                    'bg' => '#c98296'
                ]
            ]
        ],
        [
            'value' => 'Shipment',
            'parameters' => [
                'color' => [
                    'text' => '#CD853F',
                    'bg' => '#d4975b'
                ]
            ]
        ],
        [
            'value' => 'Transit',
            'parameters' => [
                'color' => [
                    'text' => '#6C5B7B',
                    'bg' => '#826e94'
                ]
            ]
        ],
        [
            'value' => 'Customs',
            'parameters' => [
                'color' => [
                    'text' => '#355C7D',
                    'bg' => '#43759f'
                ]
            ]
        ],
        [
            'value' => 'Tashkent',
            'parameters' => [
                'color' => [
                    'text' => '#158078',
                    'bg' => '#1caea3'
                ]
            ]
        ],
        [
            'value' => 'Delivering',
            'parameters' => [
                'color' => [
                    'text' => '#1FCECB',
                    'bg' => '#35e0dd'
                ]
            ]
        ],
        [
            'value' => 'Delivered',
            'parameters' => [
                'color' => [
                    'text' => '#1CD3A1',
                    'bg' => '#33e4b3'
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

    /**
     * @var array[]
     */
    public static $pickup = [
        [
            'value' => 'Pending',

            'parameters' => [
                'color' => [
                    'bg' => '#f9bca4',

                    'text' => '#F8B195'
                ]
            ]
        ],

        [
            'value' => 'On the road',

            'parameters' => [
                'color' => [
                    'bg' => '#35e0dd',

                    'text' => '#1FCECB'
                ]
            ]
        ],

        [
            'value' => 'At the office',

            'parameters' => [
                'color' => [
                    'bg' => '#33e4b3',

                    'text' => '#1CD3A1'
                ]
            ]
        ]
    ];

    /**
     * @var array[]
     */
    public static $delivery = [
        [
            'value' => 'Created',

            'parameters' => [
                'color' => [
                    'bg' => '#f9bca4',

                    'text' => '#F8B195'
                ]
            ],
        ],

        [
            'value' => 'Delivering',

            'parameters' => [
                'color' => [
                    'bg' => '#1FCECB',

                    'text' => '#35e0dd'
                ]
            ]
        ],

        [
            'value' => 'Delivered',

            'parameters' => [
                'color' => [
                    'bg' => '#1CD3A1',

                    'text' => '#33e4b3'
                ]
            ]
        ]
    ];

    /**
     * @var array[]
     */
    public static $shipment = [
        [
            'value' => 'Created',

            'parameters' => [
                'color' => [
                    'bg' => '#F8B195',

                    'text' => '#f9bca4',
                ]
            ],
        ],

        [
            'value' => 'Transiting',

            'parameters' => [
                'color' => [
                    'bg' => '#1FCECB',

                    'text' => '35e0dd',
                ]
            ],
        ],

        [
            'value' => 'Transported',

            'parameters' => [
                'color' => [
                    'bg' =>  '#1CD3A1',

                    'text' => '33e4b3',
                ],
            ],
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

        $this->createStatusesForModel(self::$delivery, Delivery::class);

        $this->createStatusesForModel(self::$shipment, Shipment::class);
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

            Status::create($item);
        }
    }
}
