<?php

namespace Database\Factories;

use App\Models\Permission;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

final class PermissionFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Permission::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Test',

            'slug' => Str::slug('Test'),

            'description' => 'Test permission description.',
        ];
    }
}
