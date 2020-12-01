<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Traits\Pagination\Pager;

/**
 * App\Models\Pickup
 *
 * @property int $id
 *
 * @property int $order_id
 *
 * @property int $driver_id
 *
 * @property
 */

final class Delivery extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Pager;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $casts = [];
}
