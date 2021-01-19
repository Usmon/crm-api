<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Product
 *
 * @property integer $id
 *
 * @property integer $order_id
 *
 * @property string $name
 *
 * @property string $status
 *
 * @property integer $quantity
 *
 * @property float $price
 *
 * @property float $weight
 *
 * @property string $type_weight
 *
 * @property string $note
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property integer $deleted_by
 *
 * @property-read HasOne $order
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Product extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $fillable = [
        'order_id',

        'name',

        'status',

        'quantity',

        'price',

        'weight',

        'type_weight',

        'note',

        'deleted_by'
    ];

    const STATUSES = [
        'created',

        'waiting in office',

        'at the office',

        'shipment',

        'transit',

        'customs',

        'tashkent',

        'delivering',

        'delivered',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'order_id' => 'integer',

        'name' => 'string',

        'status' => 'string',

        'quantity' => 'integer',

        'price' => 'float',

        'weight' => 'float',

        'type_weight' => 'string',

        'note' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer',
    ];

    /**
     * @return HasOne
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class,'id','order_id');
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
                    ->orWhere('status','like','%'. $search .'%')
                    ->orWhere('note','like','%'. $search .'%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
                return $query->whereBetween('created_at', $date);
        })->when($filters['name'] ?? null, function (Builder $query, string $name){
                return $query->where('name', 'like', '%'. $name .'%');
        })->when($filters['status'] ?? null, function (Builder $query, string $status) {
            return $query->where('status', 'like', '%' . $status . '%');
        })->when($filters['order_id'] ?? null, function (Builder $query, int $orderId) {
            return $query->where('order_id', '=', $orderId);
        })->when($filters['quantity'] ?? null, function (Builder $query, array $quantity) {
            return $query->whereBetween('quantity', $quantity);
        })->when($filters['price'] ?? null, function (Builder $query, array $price) {
            return $query->whereBetween('price', $price);
        })->when($filters['weight'] ?? null, function (Builder $query, array $weight) {
            return $query->whereBetween('weight', $weight);
        })->when($filters['type_weight'] ?? null, function (Builder $query, string $typeWeight) {
            return $query->where('type_weight', $typeWeight);
        })->when($filters['note'] ?? null, function (Builder $query, string $note) {
            return $query->where('note', 'like', '%'. $note .'%');
        });
    }
}
