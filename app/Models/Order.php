<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

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
 * @property integer $total_boxes
 *
 * @property double $total_weight_boxes
 *
 * @property integer $total_delivered_boxes
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @const STATUSES
 *
 * @const PAYMENT_STATUSES
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
 * @property-read HasMany|null $boxes
 *
 * @property-read int totalBoxes
 *
 * @property-read double totalWeightBoxes
 *
 * @property-read int totalDeliveredBoxes
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
    use Sorter;
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

        'total_boxes',

        'total_weight_boxes',

        'total_delivered_boxes',
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

        'total_boxes' => 'integer',

        'total_weight_boxes' => 'double',

        'total_delivered_boxes' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    const STATUSES = [
        'created',

        'picked_up',

        'waiting',

        'pending',

        'shipping',

        'shipped',

        'delivering',

        'delivered',

        'canceled'
    ];

    const PAYMENT_STATUSES = [
        'payed',

        'debt',
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
     * @return HasMany
     */
    public function boxes(): HasMany
    {
        return $this->hasMany(Box::class);
    }

    /**
     * @return int
     */
    public function getTotalBoxesAttribute(): int
    {
        return $this->hasMany(Box::class)->count();
    }

    /**
     * @return float
     */
    public function getTotalWeightBoxesAttribute(): float
    {
        return $this->boxes()->sum('weight');
    }

    /**
     * @return int
     */
    public function getTotalDeliveredBoxesAttribute(): int
    {
        return $this->boxes()->where('status','=','delivered')->count();
    }

    /**
     * @return float
     */
    public function getTotalPriceBoxesAttribute(): float
    {
        return $this->boxes()->sum('price');
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
        })->when($filters['total_boxes'] ?? null, function (Builder $query, array $total_boxes) {
            return $query->whereBetween('total_boxes', $total_boxes);
        })->when($filters['total_weight_boxes'] ?? null, function (Builder $query, array $total_weight_boxes) {
            return $query->whereBetween('total_weight_boxes', $total_weight_boxes);
        })->when($filters['total_delivered_boxes'] ?? null, function (Builder $query, array $total_delivered_boxes) {
            return $query->whereBetween('total_delivered_boxes', $total_delivered_boxes);
        })->when($filters['staff'] ?? null, function (Builder $query, string $staff) {
            return $query->whereHas('staff', function (Builder $query) use ($staff) {
                $query->where('login', 'like', '%' . $staff . '%')
                    ->orWhere('email', 'like', '%' . $staff . '%')
                    ->orWhere('profile', 'like', '%' . $staff . '%');
            });
        })->when($filters['customer'] ?? null, function (Builder $query, string $customer) {
            return $query->whereHas('customer', function (Builder $query) use ($customer) {
                $query->where('login', 'like', '%' . $customer . '%')
                    ->orWhere('email', 'like', '%' . $customer . '%')
                    ->orWhere('profile', 'like', '%' . $customer . '%');
            });
        })->when($filters['shipment'] ?? null, function (Builder $query, string $shipment) {
            return $query->whereHas('shipment', function (Builder $query) use ($shipment) {
                $query->where('name', 'like', '%' . $shipment . '%')
                    ->orWhere('status', 'like', '%' . $shipment . '%');
            });
        })->when($filters['pickup'] ?? null, function (Builder $query, string $pickup) {
            return $query->whereHas('pickup', function (Builder $query) use ($pickup) {
                $query->whereHas('staff', function (Builder $query) use ($pickup) {
                    $query->where('login', 'like', '%' . $pickup . '%')
                        ->orWhere('email', 'like', '%' . $pickup . '%')
                        ->orWhere('profile', 'like', '%' . $pickup . '%');
                })->whereHas('driver', function (Builder $query) use ($pickup) {
                    $query->where('login', 'like', '%' . $pickup . '%')
                        ->orWhere('email', 'like', '%' . $pickup . '%')
                        ->orWhere('profile', 'like', '%' . $pickup . '%');
                })->whereHas('customer', function (Builder $query) use ($pickup) {
                    $query->where('login', 'like', '%' . $pickup . '%')
                        ->orWhere('email', 'like', '%' . $pickup . '%')
                        ->orWhere('profile', 'like', '%' . $pickup . '%');
                })->orWhere('note', 'like', '%' . $pickup . '%');
            });
        });
    }
}
