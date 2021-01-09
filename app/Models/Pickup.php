<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Pickup
 *
 * @property int $id
 *
 * @property string $note
 *
 * @property string $bring_address
 *
 * @property Carbon $bring_datetime_start
 *
 * @property Carbon $bring_datetime_end
 *
 * @property int staff_id
 *
 * @property int driver_id
 *
 * @property int customer_id
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property int|null $deleted_by
 *
 * @property-read Collection|User[] $users
 *
 * @property-read Collection|Order[] $orders
 *
 * @property-read HasOne|null $staff
 *
 * @property-read HasOne|null $driver
 *
 * @property-read HasOne|null $customer
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
      'note',

      'bring_address',

      'bring_datetime_start',

      'bring_datetime_end',

      'staff_id',

      'driver_id',

      'customer_id',

      'deleted_by',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'note' => 'string',

        'bring_address' => 'string',

        'bring_datetime_start' => 'datetime',

        'bring_datetime_end' => 'datetime',

        'staff_id' => 'integer',

        'driver_id' => 'integer',

        'customer_id' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer'
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function staff(): HasOne
    {
        return $this->hasOne(User::class,'id','staff_id');
    }

    /**
     * @return HasOne
     */
    public function driver(): HasOne
    {
        return $this->hasOne(User::class,'id','driver_id');
    }

    /**
     * @return HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(User::class,'id','customer_id');
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
        return $query->when($filters['search'] ?? null, function (Builder $query, string $search) {
            return $query->where(function (Builder $query) use ($search) {
                return $query->where('note', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['note'] ?? null, function (Builder $query, string $note) {
            return $query->orWhere('note', 'like', '%'. $note .'%');
        })->when($filters['bring_address'] ?? null, function (Builder $query, string $bringAddress) {
            return $query->orWhere('bring_address', 'like', '%'. $bringAddress .'%');
        })->when($filters['bring_datetime_start'] ?? null, function (Builder $query, array $bringDatetimeStart) {
            return $query->orWhereBetween('bring_datetime_start', $bringDatetimeStart);
        })->when($filters['bring_datetime_end'] ?? null, function (Builder $query, array $bringDatetimeEnd) {
            return $query->orWhereBetween('bring_datetime_end', $bringDatetimeEnd);
        })->when($filters['staff_id'] ?? null, function (Builder $query, int $staff_id) {
            return $query->orWhere('staff_id', '=', $staff_id);
        })->when($filters['driver_id'] ?? null, function (Builder $query, int $driver_id) {
            return $query->orWhere('driver_id', '=', $driver_id);
        })->when($filters['customer_id'] ?? null, function (Builder $query, int $customer_id) {
            return $query->orWhere('customer_id', '=', $customer_id);
        })->when($filters['staff'] ?? null, function (Builder $query, string $customer) {
            return $query->whereHas('staff', function (Builder $query) use ($customer) {
                $query->orWhere('login', 'like', '%' . $customer . '%')
                    ->orWhere('email', 'like', '%' . $customer . '%')
                    ->orWhere('profile', 'like', '%' . $customer . '%');
            });
        })->when($filters['driver'] ?? null, function (Builder $query, string $driver) {
            return $query->whereHas('driver', function (Builder $query) use ($driver) {
                $query->orWhere('login', 'like', '%' . $driver . '%')
                    ->orWhere('email', 'like', '%' . $driver . '%')
                    ->orWhere('profile', 'like', '%' . $driver . '%');
            });
        })->when($filters['customer'] ?? null, function (Builder $query, string $customer) {
            return $query->whereHas('customer', function (Builder $query) use ($customer) {
                $query->orWhere('login', 'like', '%' . $customer . '%')
                    ->orWhere('email', 'like', '%' . $customer . '%')
                    ->orWhere('profile', 'like', '%' . $customer . '%');
            });
        });
    }
}
