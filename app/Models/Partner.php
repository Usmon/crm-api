<?php

namespace App\Models;

use App\Models\City;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\HasOne;

final class Partner extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'partners';

    /**
     * @var array
     */
    protected $fillable = [
        'city_id',
        
        'name',
        
        'address',
        
        'phone',

        'description'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'city_id' => 'integer',

        'name' => 'string',
        
        'address' => 'string',

        'phone' => 'string',

        'description' => 'string'
    ];

    /**
     * @return HasOne
     */
    protected function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
