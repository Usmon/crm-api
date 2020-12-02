<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property string $status
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 */

final class Delivery extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Pager;

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
    protected $hidden = [];

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

    /**
     * @return BelongsTo
     */
    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        });
    }
}
