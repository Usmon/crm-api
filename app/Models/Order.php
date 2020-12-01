<?php

namespace App\Models;

use App\Models\Pickup;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;


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
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Order extends Model
{
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
        return $this->HasOne(User::class, 'id');
    }

    /**
     * @return HasOne
     */
    public function customer(): HasOne
    {
        return $this->HasOne(User::class, 'id');
    }

    /**
     * @return HasOne
     */
    public function fedex_order(): HasOne
    {
        return $this->HasOne(FedexOrder::class, 'id');
    }

    /**
     * @return HasOne
     */
    public function pickup():HasOne
    {
        return $this->HasOne(Pickup::class,'id');
    }

    /**
     * @return HasOne
     */
    public function shipment(): HasOne
    {
        return $this->HasOne(Shipment::class, 'id');
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
            })->when($filters['date'] ?? null, function (Builder $query, array $date) {
                return $query->whereBetween('created_at', $date);
            });
        })->when($filters['status'] ?? null, function (Builder $query, string $search){
            return $query->where('status','like','%'. $search .'%');
        })->when($filters['payment_status'] ?? null, function (Builder $query, string $search){
            return $query->where('payment_status','like','%'. $search .'%');
        })->when($filters['price'] ?? null, function (Builder $query, int $search){
            return $query->where('price','like','%'. $search .'%');
        })->when($filters['payed_price'] ?? null, function (Builder $query, int $search){
            return $query->where('payed_price','like','%'. $search .'%');
        });
    }
}
