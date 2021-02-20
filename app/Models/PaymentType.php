<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

final class PaymentType extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'payment_types';

    /**
     * @var array
     */
    protected $fillable = [
        'name',

        'slug',

        'parameters',

        'is_active'
    ];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'string',

        'slug' => 'string',

        'parameters' => 'json',

        'is_active' => 'boolean'
    ];
}
