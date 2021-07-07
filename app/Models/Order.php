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

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property int $delivery_id
 *
 * @property double $price
 *
 * @property double $price_fedex
 *
 * @property double $payed_price
 *
 * @property integer $status_id
 *
 * @property integer $payment_status_id
 *
 * @property integer $total_boxes
 *
 * @property double $additional_weight
 *
 * @property integer $total_products
 *
 * @property double $price_pickup
 *
 * @property double $price_debt
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
 * @property-read BelongsTo $paymentType
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
 * @property-read int $totalBoxes
 *
 * @property-read double totalWeightBoxes
 *
 * @property-read HasOne $status
 *
 * @property-read HasOne $payment_status
 *
 * @property-read HasOne $sender
 *
 * @property-read HasOne|Recipient $recipient
 *
 * @property-read HasMany $histories
 *
 * @property-read int $totalDeliveredBoxes
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
     * @var string STATUS_PAYMENT
     */
    const STATUS_PAYMENT = 'OrderPayment';

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array
     */
    protected $fillable = [
        'staff_id',

        'fedex_order_id',

        'pickup_id',

        'shipment_id',

        'sender_id',

        'recipient_id',

        'delivery_id',

        'type',

        'price',

        'price_insurance',

        'price_warehouse',

        'price_delivery',

        'price_total',

        'price_debt',

        'weight_rate',

        'payment_type_id',

        'payed_price',

        'status_id',

        'payment_status_id',

        'total_boxes',

        'total_weight_boxes',

        'total_delivered_boxes',

        'additional_weight',

        'price_additional',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'staff_id' => 'integer',

        'fedex_order_id' => 'integer',

        'pickup_id' => 'integer',

        'shipment_id' => 'integer',

        'sender_id' => 'integer',

        'recipient_id' => 'integer',

        'delivery_id' => 'integer',

        'type' => 'json',

        'price' => 'double',

        'price_insurance' => 'double',

        'price_warehouse' => 'double',

        'price_delivery' => 'double',

        'price_total' => 'double',

        'price_debt' => 'double',

        'weight_rate' => 'integer',

        'payment_type_id' => 'array',

        'payed_price' => 'double',

        'status_id' => 'integer',

        'payment_status_id' => 'integer',

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
        return $this->hasMany(Delivery::class, 'id', 'order_id');
    }

    /**
     * @return HasMany
     */
    public function boxes(): HasMany
    {
        return $this->hasMany(Box::class);
    }

    /**
     * @return HasOne
     */
    public function sender(): HasOne
    {
        return $this->hasOne(Sender::class, 'id', 'sender_id');
    }

    /**
     * @return HasOne
     */
    public function recipient(): HasOne
    {
        return $this->hasOne(Recipient::class, 'id', 'recipient_id');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'order_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * @return BelongsTo
     */
    public function payment_status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
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
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getPaymentTypeAttribute()
    {
        return PaymentType::query()->whereIn('id', $this->payment_type_id)->get()->map(function (PaymentType $paymentType){
            return $paymentType->name;
        });
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
     * @return float
     */
    public function getTotalAdditionalWeightAttribute(): float
    {
        return $this->boxes()->sum('additional_weight');
    }

    /**
     * @return int
     */
    public function getTotalDeliveredBoxesAttribute(): int
    {
        //@todo by order id
        return $this->boxes()->count();
    }

    /**
     * @return float
     */
    public function getTotalPriceBoxesAttribute(): float
    {
        $sum = 0;
        foreach ($this->boxes as $box) {
            $sum += $box->total_price;

        }

        return (float) $sum;
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
     * @return float
     */
    public function getPricePickupAttribute(): float
    {
        return (float) 0;
    }

    /**
     * @return int
     */
    public function getTotalProductsAttribute(): int
    {
        return $this->boxes->map(function(Box $box) {
            return $box->items->count();
        })->sum();
    }


    /**
     * @return float
     */
    public function getPriceFedexAttribute(): float
    {
        return $this->fedex_order->price ?? 0;
    }

    /**
     * @return float
     */
    public function getPriceDiscountAttribute(): float
    {
        return $this->staff->partner->discount_price;
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
            return $query->whereHas('staff', function (Builder $query) use ($search) {
                return $query->whereHas('partner', function (Builder $query) use ($search) {
                    return $query->where('name', 'like', '%'.$search.'%')
                                 ->orWhere('phone', 'like', '%'.$search.'%');
                })->orWhere('email', 'like', '%'.$search.'%')
                  ->orWhere('login', 'like', '%'.$search.'%')
                  ->orWhere('full_name', 'like', '%'.$search.'%');
            })->orWhereHas('sender', function (Builder $query) use ($search) {
                return $query->whereHas('customer', function (Builder $query) use ($search) {
                    return $query->whereHas('user', function(Builder $query) use ($search) {
                        return $query->where('email', 'like', '%'.$search.'%')
                                     ->orWhere('login', 'like', '%'.$search.'%')
                                     ->orWhere('full_name', 'like', '%'.$search.'%');
                    });
                });
            })->orWhereHas('recipient', function (Builder $query) use ($search) {
                return $query->whereHas('customer', function (Builder $query) use ($search) {
                    return $query->whereHas('user', function(Builder $query) use ($search) {
                        return $query->where('email', 'like', '%'.$search.'%')
                            ->orWhere('login', 'like', '%'.$search.'%')
                            ->orWhere('full_name', 'like', '%'.$search.'%');
                    });
                });
            })->orWhere('id', '=', (int) $search);
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['status_id'] ?? null, function (Builder $query, int $status_id){
            return $query->where('status_id', $status_id);
        })->when($filters['payment_status_id'] ?? null, function (Builder $query, int $payment_status_id){
            return $query->where('payment_status_id', $payment_status_id);
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
        })->when($filters['partner_id'] ?? null, function (Builder $query, int $partner_id) {
            return $query->whereHas('staff', function (Builder $query) use ($partner_id) {
                $query->where('partner_id', $partner_id);
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
