<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *
 * App\Models\FedexOrder
 *
 * @property int $id
 *
 * @property double $price
 *
 * @property double $discount_price
 *
 * @property array $service_type
 *
 * @property string $tracking_number
 *
 * @property string $transit_time
 *
 * @property string $label_file
 *
 * @property array $status
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read HasOne|null $staff
 *
 * @property-read HasOne|null $customer
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class FedexOrder extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'fedex_orders';

    /**
     * @var array
     */
    protected $fillable = [
        'price',

        'discount_price',

        'service_type',

        'tracking_number',

        'label_file',

        'transit_time',

        'status',

        'staff_id',

        'customer_id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'price' => 'double',

        'discount_price' => 'double',

        'service_type' => 'string',

        'tracking_number' => 'string',

        'label_file' => 'string',

        'transit_time' => 'string',

        'status' => 'string',

        'staff_id' => 'integer',

        'customer_id' => 'integer',

        'arrived_at' => 'datetime',

        'updated_at' => 'datetime',

        'delete_at' => 'datetime'
    ];

    /**
     * @var string[]
     */
    public $attributes = [
        'service_type' => 'ground',

        'status' => 'pending'
    ];

    /**
     * @return HasOne
     */
    public function staff():HasOne
    {
        return $this->hasOne(User::class,'id','staff_id');
    }

    /**
     * @return HasOne
     */
    public function customer():HasOne
    {
        return $this->hasOne(User::class,'id','customer_id');
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(FedexOrderItem::class);
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
        })->when($filters['customer_id'] ?? null, function (Builder $query, int $customer_id) {
                return $query->where('customer_id', '=', $customer_id);
        })->when($filters['staff_id'] ?? null, function (Builder $query, int $staff_id) {
                return $query->where('staff_id', '=', $staff_id);
        });
    }
}
