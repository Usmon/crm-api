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
                    'bg' => '#FEF3EF'
                ]
            ]
        ],
        [
            'value' => 'At the office',
            'parameters' => [
                'color' => [
                    'text' => '#C06C84',
                    'bg' => '#F6E9ED'
                ]
            ]
        ],
        [
            'value' => 'Shipment',
            'parameters' => [
                'color' => [
                    'text' => '#CD853F',
                    'bg' => '#F8EDE2'
                ]
            ]
        ],
        [
            'value' => 'Transit',
            'parameters' => [
                'color' => [
                    'text' => '#6C5B7B',
                    'bg' => '#E9E6EB'
                ]
            ]
        ],
        [
            'value' => 'Customs',
            'parameters' => [
                'color' => [
                    'text' => '#355C7D',
                    'bg' => '#E1E7EC'
                ]
            ]
        ],
        [
            'value' => 'Tashkent',
            'parameters' => [
                'color' => [
                    'text' => '#158078',
                    'bg' => '#DCECEB'
                ]
            ]
        ],
        [
            'value' => 'Delivering',
            'parameters' => [
                'color' => [
                    'text' => '#1FCECB',
                    'bg' => '#DDF8F7'
                ]
            ]
        ],
        [
            'value' => 'Delivered',
            'parameters' => [
                'color' => [
                    'text' => '#1CD3A1',
                    'bg' => '#DDF9F1'
                ]
            ]
        ],
    ];

    /**
     * @var array
     */
    public static $order_payment = [
        [
            'value' => 'Pending',
            'parameters' => [
                'color' => [
                    'bg' => '#FFA800',
                    'text' => '#FFF2D9'
                ]
            ]
        ],
        [
          'value' =>  'Paid',
          'parameters' => [
            'color' => [
                'bg' => '#1BC585',
                'text' => '#DDF7ED'
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
                    'bg' => '#F8B195',

                    'text' => '#FEF3EF'
                ]
            ]
        ],

        [
            'value' => 'On the road',

            'parameters' => [
                'color' => [
                    'bg' => '#1FCECB',

                    'text' => '#DDF8F7'
                ]
            ]
        ],

        [
            'value' => 'At the office',

            'parameters' => [
                'color' => [
                    'bg' => '#1CD3A1',

                    'text' => '#DDF9F1'
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
                    'bg' => '#F8B195',

                    'text' => '#FEF3EF'
                ]
            ],
        ],

        [
            'value' => 'Delivering',

            'parameters' => [
                'color' => [
                    'bg' => '#1FCECB',

                    'text' => '#DDF8F7'
                ]
            ]
        ],

        [
            'value' => 'Delivered',

            'parameters' => [
                'color' => [
                    'bg' => '#1CD3A1',

                    'text' => '#DDF9F1'
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

                    'text' => '#FEF3EF',
                ]
            ],
        ],

        [
            'value' => 'Transiting',

            'parameters' => [
                'color' => [
                    'bg' => '#1FCECB',

                    'text' => '#DDF8F7',
                ]
            ],
        ],

        [
            'value' => 'Transported',

            'parameters' => [
                'color' => [
                    'bg' =>  '#1CD3A1',

                    'text' => '#DDF9F1',
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
