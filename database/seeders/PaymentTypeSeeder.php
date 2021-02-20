<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\PaymentType;

final class PaymentTypeSeeder extends Seeder
{

    /**
     * @var array[] $types
     */
    protected $types = [
        ['name' => 'Clover', 'slug' => 'clover', 'parameters' => [], 'is_active' => true],

        ['name' => 'Zelle', 'slug' => 'zelle', 'parameters' => [], 'is_active' => true],

        ['name' => 'Cash', 'slug' => 'cash', 'parameters' => [], 'is_active' => true]
    ];

    /**
     * @return void
     */
    public function run(): void
    {
        foreach ($this->types as $type) {
            PaymentType::create($type);
        }
    }
}
