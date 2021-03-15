<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Traits\Pagination\Pager;

use App\Traits\Sort\Sorter;

/**
 * App\Models\Box
 *
 * @property int $id
 *
 * @property int $pickup_id
 *
 * @property int $order_id
 *
 * @property float $weight
 *
 * @property float $additional_weight
 *
 * @property int $status_id
 *
 * @property int $creator_id
 *
 * @property string $box_image
 *
 * @property string $note
 *
 * @property int $delivery_id
 *
 * @property-read HasOne|null $pickup
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property int|null $deleted_by
 *
 * @property-read HasOne|null $status
 *
 * @property-read HasOne|null $delivery
 *
 * @property-read HasOne|null $creator
 *
 * @property-read HasOne|null $order
 *
 */

final class Box extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Pager;
    use Sorter;

    /**
     * @var string
     */
    protected $table = 'boxes';

    /**
     * @var array
     */
    protected $fillable = [
        'pickup_id',

        'order_id',

        'status_id',

        'note',

        'weight',

        'additional_weight',

        'box_image',

        'delivery_id',

        'shipment_id',

        'creator_id',
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

        'pickup_id' => 'integer',

        'order_id' => 'integer',

        'status_id' => 'integer',

        'weight' => 'float',

        'additional_weight' => 'float',

        'box_image' => 'string',

        'delivery_id' => 'integer',

        'shipment_id' => 'integer',

        'creator_id' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return HasOne
     */
    public function pickup(): HasOne
    {
        return $this->hasOne(Pickup::class, 'id', 'pickup_id');
    }

    /**
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(BoxItem::class);
    }

    /**
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class,'id','status_id');
    }

    /**
     * @return HasOne
     */
    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class,'id','delivery_id');
    }

    /**
     * @return int
     */
    public function getTotalProductsAttribute(): int
    {
        return $this->items()->count();
    }

    /**
     * @return int
     */
    public function getTotalPriceAttribute(): int
    {
        return $this->items()->sum('price');
    }

    /**
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }

    public function getTotalWeightAttribute(): float
    {
        return $this->weight;
    }

    /**
     * @return HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(OrderHistory::class, 'model_id', 'id')
            ->where('model', self::class);
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
        })->when($filters['pickup_id'] ?? null, function (Builder $query, int $pickupId){
            return $query->where('box_id', '=', $pickupId);
        })->when($filters['status_id'] ?? null, function (Builder $query, int $customerId){
            return $query->where('customer_id', '=', $customerId);
        })->when($filters['delivery_id'] ?? null, function (Builder $query, int $customerId){
            return $query->where('customer_id', '=', $customerId);
        })->when($filters['status'] ?? null, function (Builder $query, string $status){
            return $query->whereHas('status', function (Builder $query) use ($status) {
                return $query->where('model','like','%'. $status .'%')
                    ->orWhere('key', 'like', '%'. $status .'%')
                    ->orWhere('value', 'like', '%'. $status .'%')
                    ->orWhere('parameters', 'like', '%'. $status .'%');
            });
        })->when($filters['weight'] ?? null, function (Builder $query, array $weight){
            return $query->whereBetween('weight', $weight);
        })->when($filters['additional_weight'] ?? null, function (Builder $query, array $additionalWeight){
            return $query->whereBetween('additional_weight', $additionalWeight);
        });
    }
}
