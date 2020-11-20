<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Pickup extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'pickups';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @var array
     */
    protected $casts = [];
}
