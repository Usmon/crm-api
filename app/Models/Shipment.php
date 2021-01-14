<?php

namespace App\Models;

use App\Traits\Sort\Sorter;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Shipment
 *
 * @property int $id
 *
 * @property string $name
 *
 * @property string $status
 *
 * @property integer $total_boxes
 *
 * @property double $total_weight_boxes
 *
 * @property integer $total_price_orders
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @const STATUSES
 *
 * @property-read HasMany|null $orders
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Shipment extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'shipments';

    /**
     * @var array
     */
    protected $fillable = [
        'name',

        'status',

        'total_boxes',

        'total_weight_boxes',

        'total_price_orders',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'name' => 'string',

        'status' => 'string',

        'total_boxes' => 'integer',

        'total_weight_boxes' => 'float',

        'total_price_orders' => 'double',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    const STATUSES = [
        'pending',

        'shipping',

        'shipped',
    ];

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
    public function getTotalBoxesAttribute(): int
    {
        return $this->orders()->sum('total_boxes');
    }

    /**
     * @return float
     */
    public function getTotalWeightBoxesAttribute(): float
    {
        return $this->orders()->sum('total_weight_boxes');
    }

    /**
     * @return float
     */
    public function getTotalPriceOrdersAttribute(): float
    {
        return $this->orders()->sum('price');
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
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['name'] ?? null, function (Builder $query, string $name) {
            return $query->where('name', 'like', '%'. $name .'%');
        })->when($filters['status'] ?? null, function (Builder $query, string $status) {
            return $query->where('status', 'like', '%'. $status .'%');
        });
    }
}
