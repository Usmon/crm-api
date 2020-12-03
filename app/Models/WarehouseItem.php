<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * App\Models\WarehouseItem
 *
 * @property int $id
 *
 * @property int $customer_id
 *
 * @property int $shipment_id
 *
 * @property string $name
 *
 * @property int $init_quantity
 *
 * @property int $quantity
 *
 * @property double $init_weight
 *
 * @property double $weight
 *
 * @property double $total_price
 *
 * @property double $payed
 *
 * @property string $note
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 */

final class WarehouseItem extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'warehouse_items';

    /**
     * @var array
     */
    protected $fillable = [
        'customer_id',

        'shipment_id',

        'name',

        'init_quantity',

        'quantity',

        'init_weight',

        'weight',

        'total_price',

        'payed',

        'note'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'customer_id' => 'integer',

        'shipment_id' => 'integer',

        'name' => 'string',

        'init_quantity' => 'integer',

        'quantity' => 'integer',

        'init_weight' => 'double',

        'weight' => 'double',

        'total_price' => 'double',

        'payed' => 'double',

        'note' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];
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
                    ->orWhere('note', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['name'] ?? null, function (Builder $query, string $name) {
            return $query->where('name', 'like', '%'. $name .'%');
        })->when($filters['note'] ?? null, function (Builder $query, string $note) {
            return $query->where('note', 'like', '%'. $note .'%');
        });
    }
}
