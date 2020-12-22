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
 * App\Models\Order
 *
 * @property int $id
 *
 * @property int $staff_id
 *
 * @property int $customer_id
 *
 * @property int $fedex_order_id
 *
 * @property int $pickup_id
 *
 * @property int $shipment_id
 *
 * @property double $price
 *
 * @property double $payed_price
 *
 * @property string $status
 *
 * @property string $payment_status
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
 * @property-read HasOne|null $fedex_order
 *
 * @property-read HasOne|null $pickup
 *
 * @property-read HasOne|null $shipment
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Order extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array
     */
    protected $fillable = [
        'staff_id',

        'customer_id',

        'fedex_order_id',

        'pickup_id',

        'shipment_id',

        'price',

        'payed_price',

        'status',

        'payment_status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'staff_id' => 'integer',

        'customer_id' => 'integer',

        'fedex_order_id' => 'integer',

        'pickup_id' => 'integer',

        'shipment_id' => 'integer',

        'price' => 'double',

        'payed_price' => 'double',

        'status' => 'string',

        'payment_status' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    /**
     * @return HasOne
     */
    public function staff(): HasOne
    {
        return $this->HasOne(User::class, 'id', 'staff_id');
    }

    /**
     * @return HasOne
     */
    public function customer(): HasOne
    {
        return $this->HasOne(User::class, 'id', 'customer_id');
    }

    /**
     * @return HasOne
     */
    public function fedex_order(): HasOne
    {
        return $this->HasOne(FedexOrder::class, 'id', 'fedex_order_id');
    }

    /**
     * @return HasOne
     */
    public function pickup():HasOne
    {
        return $this->HasOne(Pickup::class,'id', 'pickup_id');
    }

    /**
     * @return HasOne
     */
    public function shipment(): HasOne
    {
        return $this->HasOne(Shipment::class, 'id', 'shipment_id');
    }

    /**
     * @return HasMany
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
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
                return $query->where('status', 'like', '%' . $search . '%')
                    ->orWhere('payment_status', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['status'] ?? null, function (Builder $query, string $status){
            return $query->where('status','like','%'. $status .'%');
        })->when($filters['payment_status'] ?? null, function (Builder $query, string $payment_status){
            return $query->where('payment_status','like','%'. $payment_status .'%');
        })->when($filters['price'] ?? null, function (Builder $query, array $price){
            return $query->whereBetween('price', $price);
        })->when($filters['payed_price'] ?? null, function (Builder $query, array $payed_price){
            return $query->whereBetween('payed_price', $payed_price);
        })->when($filters['staff_id'] ?? null, function (Builder $query, int $staff_id){
            return $query->where('staff_id','=', $staff_id);
        })->when($filters['customer_id'] ?? null, function (Builder $query, int $customer_id){
            return $query->where('customer_id','=', $customer_id);
        })->when($filters['fedex_order_id'] ?? null, function (Builder $query, int $fedex_order_id){
            return $query->where('fedex_order_id','=', $fedex_order_id);
        })->when($filters['pickup_id'] ?? null, function (Builder $query, int $pickup_id){
            return $query->where('pickup_id','=', $pickup_id);
        })->when($filters['shipment_id'] ?? null, function (Builder $query, int $shipment_id){
            return $query->where('shipment_id','=', $shipment_id);
        });
    }
}
