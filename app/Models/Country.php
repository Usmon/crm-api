<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Country
 *
 * @package App\Models
 *
 * @property string $code
 *
 * @property string $name
 *
 * @property int $id
 *
 * @mixin Builder
 */
final class Country extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'countries';

    /**
     * @var array
     */
    protected $fillable = [
        'name',

        'code'
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

        'code' => 'string'
    ];
}
