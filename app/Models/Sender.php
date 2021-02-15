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
 * App\Models\Sender
 *
 * @property integer $id
 *
 * @property integer $customer_id
 *
 * @property integer $region_id
 *
 * @property integer $city_id
 *
 * @property integer $address_id
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read HasOne|null $customer
 *
 * @property-read HasOne|null $region
 *
 * @property-read HasOne|null $city
 *
 * @property-read HasOne|null $address
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Sender extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;
    use Sorter;

    /**
     * @var string
     */
    protected $table = 'senders';

    /**
     * @var array
     */
    protected $fillable = [
        'customer_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'customer_id' => 'integer',

        'region_id' => 'integer',

        'city_id' => 'integer',

        'address_id' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime'
    ];

    /**
     * @return HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class,'id','customer_id')->with(['user']);
    }

    /**
     * @return HasOne
     */
    public function region(): HasOne
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    /**
     * @return HasOne
     */
    public function city(): HasOne
    {
        return $this->hasOne(City::class,'id','city_id');
    }

    /**
     * @return HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class,'id','address_id');
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
        })->when($filters['customer_id'] ?? null, function (Builder $query, int $customer_id) {
            return $query->where('customer_id', '=', $customer_id);
        })->when($filters['customer'] ?? null, function (Builder $query, string $customer) {
            return $query->whereHas('customer', function (Builder $query) use ($customer) {
                $query->whereHas('user', function (Builder $query) use ($customer) {
                    $query->whereHas('phones', function (Builder $query) use ($customer) {
                        return $query->where('phone', 'like', '%'. $customer .'%');
                    })->orWhere('login', 'like', '%' . $customer . '%')
                        ->orWhere('email', 'like', '%' . $customer . '%')
                        ->orWhere('profile', 'like', '%' . $customer . '%');
                })->orWhere('passport', 'like', '%' . $customer . '%')
                    ->orWhere('note', 'like', '%' . $customer . '%');
            });
        })->when($filters['region_id'] ?? null, function (Builder $query, string $regionId) {
            return $query->where('region_id', '=', $regionId);
        })->when($filters['city'] ?? null, function (Builder $query, string $cityId) {
            return $query->where('city_id', '=', $cityId);
        })->when($filters['address_id'] ?? null, function (Builder $query, int $addressId) {
            return $query->where('address_id', '=', $addressId);
        });
    }
}
