<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Delivery
 *
 * @property int $id
 *
 * @property int $customer_id
 *
 * @property int $driver_id
 *
 * @property int $status_id
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @const STATUSES
 *
 * @property-read HasOne|null $customer
 *
 * @property-read HasOne|null $driver
 *
 * @property-read HasOne|null $status
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 */

final class Delivery extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'deliveries';

    /**
     * @var array
     */
    protected $fillable = [
        'customer_id',

        'driver_id',

        'status_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'customer_id' => 'integer',

        'driver_id' => 'integer',

        'status_id' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];


    const STATUSES = [
        'pending',

        'delivered',

        'delivering',
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
        return $this->hasOne(Driver::class, 'id', 'driver_id')->with(['user', 'region', 'city', 'address']);
    }

    /**
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
    /**
     * @param Builder $query
     *
     * @param string $key
     *
     * @param string|null $value
     *
     * @return Builder
     */
    public function scopeFindBy(Builder $query, string $key, string $value = null): Builder
    {
        return $query->where($key, '=', $value);
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
        })->when($filters['customer_id'] ?? null, function (Builder $query, int $customerId) {
            return $query->where('customer_id', '=', $customerId);
        })->when($filters['driver_id'] ?? null, function (Builder $query, int $driverId) {
            return $query->where('driver_id', '=', $driverId);
        })->when($filters['status_id'] ?? null, function (Builder $query, int $driverId) {
            return $query->where('driver_id', '=', $driverId);
        })->when($filters['status'] ?? null, function (Builder $query, string $status) {
            return $query->whereHas('status', function (Builder $query) use ($status) {
                return $query->where('model', 'like', '%'. $status .'%')
                    ->orWhere('key', 'like', '%'. $status .'%')
                    ->orWhere('value', 'like', '%'. $status .'%')
                    ->orWhere('parameters', 'like', '%'. $status .'%');
            });
        })->when($filters['driver'] ?? null, function (Builder $query, string $driver) {
            return $query->whereHas('driver', function (Builder $query) use ($driver) {
                return $query->whereHas('user', function (Builder $query) use ($driver) {
                    return $query->whereHas('phones', function (Builder $query) use ($driver) {
                        return $query->where('phone', 'like', '%' . $driver . '%');
                    })->orWhere('login', 'like', '%' . $driver . '%')
                      ->orWhere('email', 'like', '%' . $driver . '%')
                      ->orWhere('profile', 'like', '%' . $driver . '%');
                });
            });
        })->when($filters['customer'] ?? null, function (Builder $query, string $customer) {
            return $query->whereHas('customer', function (Builder $query) use ($customer) {
                return $query->whereHas('user', function (Builder $query) use ($customer){
                    return $query->whereHas('phones', function (Builder $query) use ($customer) {
                        return $query->where('phone', 'like', '%'. $customer .'%');
                    })->orWhere('login', 'like', '%'. $customer .'%')
                        ->orWhere('email', 'like', '%'. $customer .'%')
                        ->orWhere('profile', 'like', '%'. $customer .'%');
                });
            });
        });
    }
}
