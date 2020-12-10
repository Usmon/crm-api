<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\FedexOrderItem
 *
 * @property integer $fedex_order_id
 *
 * @property double $weight
 *
 * @property integer $width
 *
 * @property integer $height
 *
 * @property integer $length
 *
 * @property double $service_price
 *
 * @property string $label_file_name
 *
 * @property string $barcode
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property integer|null $deleted_by
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class FedexOrderItem extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'fedex_order_items';

    /**
     * @var array
     */
    protected $fillable = [
        'fedex_order_id',

        'weight',

        'width',

        'height',

        'length',

        'service_price',

        'label_file_name',

        'barcode',

        'deleted_by'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'fedex_order_id' => 'integer',

        'weight' => 'double',

        'width' => 'integer',

        'height' => 'integer',

        'length' => 'integer',

        'service_price' => 'double',

        'label_file_name' => 'string',

        'barcode' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer'
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
                return $query->where('barcode', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['fedex_order_id'] ?? null, function (Builder $query, $fedex_order_id){
            return $query->where('fedex_order_id', '=', $fedex_order_id);
        })->when($filters['weight'] ?? null, function (Builder $query, array $weight){
            return $query->whereBetween('weight', $weight);
        })->when($filters['width'] ?? null, function (Builder $query, array $width){
            return $query->whereBetween('width', $width);
        })->when($filters['height'] ?? null, function (Builder $query, array $height){
            return $query->whereBetween('height', $height);
        })->when($filters['length'] ?? null, function (Builder $query, array $length){
            return $query->whereBetween('length', $length);
        })->when($filters['service_price'] ?? null, function (Builder $query, array $service_price){
            return $query->whereBetween('service_price', $service_price);
        })->when($filters['barcode'] ?? null, function (Builder $query, string $barcode){
            return $query->where('barcode', 'like', '%'. $barcode .'%');
        });
    }
}
