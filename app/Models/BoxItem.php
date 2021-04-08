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

use App\Traits\Pagination\Pager;

/**
 * App\Models\BoxItem
 *
 * @property int $id
 *
 * @property int $box_id
 *
 * @property string $name
 *
 * @property int $quantity
 *
 * @property float $price
 *
 * @property float $weight
 *
 * @property string $made_in
 *
 * @property string $note
 *
 * @property integer $is_additional
 *
 */

final class BoxItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Pager;

    /**
     * @var string
     */
    protected $table = 'box_items';

    /**
     * @var array
     */
    protected $fillable = [
        'box_id',

        'name',

        'quantity',

        'price',

        'weight',

        'made_in',

        'note',

        'image',

        'is_additional',
    ];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $casts = [
        'id ' => 'integer',

        'box_id' => 'integer',

        'name' => 'string',

        'quantity' => 'integer',

        'price' => 'float',

        'weight' => 'float',

        'made_in' => 'string',

        'note' => 'string',

        'image' => 'string',

        'is_additional' => 'integer',

    ];

    /**
     * @return BelongsTo
     */
    public function boxes(): BelongsTo
    {
        return $this->belongsTo(Box::class);
    }

    /**
     * @return BelongsTo
     */
    public function warehouse_items(): BelongsTo
    {
        return $this->belongsTo(WarehouseItem::class);
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
                    ->orWhere('made_in', 'like', '%' . $search . '%')
                    ->orWhere('note', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['quantity'] ?? null, function (Builder $query, int $quantity){
            return $query->where('quantity','=',$quantity);
        })->when($filters['weight'] ?? null, function (Builder $query, float $weight){
            return $query->where('weight','=',$weight);
        })->when($filters['price'] ?? null, function (Builder $query, float $price){
            return $query->where('price','=',$price);
        });
    }

}
