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
 * @property int $status_id
 *
 * @property int $customer_id
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
 * @property-read HasOne|null $customer
 *
 * @property-read HasOne|null $driver
 *
 * @property-read HasOne|null $creator
 *
 * @property-read HasMany|null $orders
 *
 * @property-read HasOne|null $status
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

        'status_id',

        'customer_id',

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

        'status_id' => 'integer',

        'customer_id' => 'integer',

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
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class,'id','customer_id')->with(['user']);
    }

    /**
     * @return HasOne
     */
    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class,'id','driver_id')->with(['user']);
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
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class,'id','status_id');
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
        return $query->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['pickup_datetime_start'] ?? null, function (Builder $query, array $pickupDatetimeStart){
            return $query->whereBetween('pickup_datetime_start', $pickupDatetimeStart);
        })->when($filters['pickup_datetime_end'] ?? null, function (Builder $query, array $pickupDatetimeEnd) {
            return $query->whereBetween('pickup_datetime_end', $pickupDatetimeEnd);
        })->when($filters['status'] ?? null, function (Builder $query, string $status) {
            return $query->whereHas('status', function (Builder $query) use ($status) {
                return $query->where('model', 'like', '%'. $status .'%')
                    ->orWhere('key', 'like', '%'. $status .'%')
                    ->orWhere('value', 'like', '%'. $status .'%')
                    ->orWhere('parameters', 'like', '%'. $status .'%');
            });
        })->when($filters['sender_id'] ?? null, function (Builder $query, int $senderId) {
            return $query->where('sender_id', '=', $senderId);
        })->when($filters['driver_id'] ?? null, function (Builder $query, int $driverId) {
            return $query->where('driver_id', '=', $driverId);
        })->when($filters['creator_id'] ?? null, function (Builder $query, int $creatorId) {
            return $query->where('creator_id', '=', $creatorId);
        })->when($filters['sender'] ?? null, function (Builder $query, string $sender) {
               return $query->whereHas('customer', function (Builder $query) use ($sender) {
                   return $query->whereHas('user', function (Builder $query) use ($sender) {
                         return $query->whereHas('phones', function (Builder $query) use ($sender) {
                             return $query->where('phone', 'like', '%'. $sender .'%');
                         })->orWhere('login', 'like', '%'. $sender .'%')
                           ->orWhere('email', 'like', '%'. $sender .'%')
                           ->orWhere('profile', 'like', '%'. $sender .'%');
                   });
               });
        })->when($filters['driver'] ?? null, function (Builder $query, string $driver) {
            return $query->whereHas('driver', function (Builder $query) use ($driver) {
                return $query->whereHas('user', function (Builder $query) use ($driver) {
                    return $query->whereHas('phones', function (Builder $query) use ($driver) {
                        return $query->where('phone', 'like', '%'. $driver .'%');
                    });
                });
            });
        });
    }
}
