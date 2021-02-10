<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Pickup
 *
 * @property int $id
 *
 * @property Carbon $pickup_datetime_start
 *
 * @property Carbon $pickup_datetime_end
 *
 * @property string $status
 *
 * @property int $sender_id
 *
 * @property int $driver_id
 *
 * @property int $creator_id
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property int|null $deleted_by
 *
 * @property-read HasOne|null $sender
 *
 * @property-read HasOne|null $driver
 *
 * @property-read HasOne|null $creator
 *
 * @property-read HasMany|null $orders
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Pickup extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Pager;
    use Sorter;

    /**
     * @var string
     */
    protected $table = 'pickups';

    /**
     * @var array
     */
    protected $fillable = [
        'pickup_datetime_start',

        'pickup_datetime_end',

        'status',

        'sender_id',

        'driver_id',

        'creator_id',

        'deleted_by',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'pickup_datetime_start' => 'datetime',

        'pickup_datetime_end' => 'datetime',

        'status' => 'string',

        'sender_id' => 'integer',

        'driver_id' => 'integer',

        'creator_id' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer'
    ];

    const STATUSES = [
        'pending',

        'on_the_road',

        'at_the_office',
    ];

    /**
     * @return HasOne
     */
    public function sender(): HasOne
    {
        return $this->hasOne(Sender::class,'id','sender_id');
    }

    /**
     * @return HasOne
     */
    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class,'id','driver_id');
    }

    /**
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class,'id','creator_id');
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->with(['boxes']);
    }

    /**
     * @return int
     */
    public function totalOrders(): int
    {
        return $this->orders->count();
    }

    /**
     * @return int
     */
    public function totalBoxes(): int
    {
        return $this->orders->sum('total_boxes');
    }

    /**
     * @return int
     */
    public function totalDeliveredBoxes(): int
    {
        return $this->orders->sum('total_delivered_boxes');
    }

    /**
     * @param Builder $query
     *
     * @param array $filters
     *
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        //todo filter
    }
}
