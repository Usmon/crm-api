<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Delivery
 *
 * @property int $id
 *
 * @property int $order_id
 *
 * @property int $driver_id
 *
 * @property string $status
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read BelongsTo|null $order
 *
 * @property-read BelongsTo|null $driver
 *
 * @property-read array $statuses
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
        'order_id',

        'driver_id',

        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'order_id' => 'integer',

        'driver_id' => 'integer',

        'status' => 'string',

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
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    /**
     * @return BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
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
                return $query->where('status', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['status'] ?? null, function (Builder $query, string $status) {
            return $query->where('status', 'like','%'. $status .'%');
        })->when($filters['order_id'] ?? null, function (Builder $query, int $order_id) {
            return $query->where('order_id', '=', $order_id);
        })->when($filters['driver_id'] ?? null, function (Builder $query, int $driver_id) {
            return $query->where('driver_id', '=', $driver_id);
        });
    }
}
