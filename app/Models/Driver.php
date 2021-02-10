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
 * App\Models\Driver
 *
 * @property integer $id
 *
 * @property integer $creator_id
 *
 * @property integer $user_id
 *
 * @property string $phone
 *
 * @property integer $city_id
 *
 * @property integer $region_id
 *
 * @property integer $address_id
 *
 * @property string $car_model
 *
 * @property string $car_number
 *
 * @property string $license
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read HasOne|null $creator
 *
 * @property-read HasOne|null $user
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
final class Driver extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'drivers';

    /**
     * @var array
     */
    protected $fillable = [
        'creator_id',

        'user_id',

        'phone',

        'city_id',

        'region_id',

        'address_id',

        'car_model',

        'car_number',

        'license',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'creator_id' => 'integer',

        'user_id' => 'integer',

        'phone' => 'string',

        'email' => 'string',

        'region_id' => 'integer',

        'city_id' => 'integer',

        'address_id' => 'integer',

        'car_model' => 'string',

        'car_number' => 'string',

        'license' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    /**
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class,'id','creator_id');
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    /**
     * @return HasOne
     */
    public function region(): HasOne
    {
        return $this->hasOne(Region::class,'id','region_id');
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
        return $query->when($filters['search'] ?? null, function (Builder $query, string $search) {
            return $query->where(function (Builder $query) use ($search) {
                return $query->orWhere('phone', 'like', '%'. $search .'%')
                    ->orWhere('car_model', 'like', '%'. $search .'%')
                    ->orWhere('car_number', 'like', '%'. $search .'%')
                    ->orWhere('license', 'like', '%'. $search .'%');
            });
        })->when($filters['name'] ?? null, function (Builder $query, string $name) {
            return $query->orWhere('name', 'like', '%'. $name .'%');
        })->when($filters['phone'] ?? null, function (Builder $query, string $phone) {
            return $query->orWhere('phone', 'like', '%' . $phone . '%');
        })->when($filters['email'] ?? null, function (Builder $query, string $email) {
            return $query->orWhere('email', 'like', '%' . $email . '%');
        })->when($filters['car_model'] ?? null, function (Builder $query, string $carModel) {
            return $query->orWhere('car_model', 'like', '%' . $carModel . '%');
        })->when($filters['car_number'] ?? null, function (Builder $query, string $carNumber) {
            return $query->orWhere('car_number', 'like', '%' . $carNumber . '%');
        })->when($filters['license'] ?? null, function (Builder $query, string $license) {
            return $query->orWhere('license', 'like', '%' . $license . '%');
        })->when($filters['region_id'] ?? null, function (Builder $query, int $region_id) {
            return $query->orWhere('region_id', '=', $region_id);
        })->when($filters['city_id'] ?? null, function (Builder $query, int $city_id) {
            return $query->orWhere('city_id', '=', $city_id);
        })->when($filters['address_id'] ?? null, function (Builder $query, int $address_id) {
            return $query->orWhere('address', '=', $address_id);
        })->when($filters['region'] ?? null, function (Builder $query, string $region) {
            return $query->whereHas('region', function (Builder $query) use ($region) {
                return $query->orWhere('region', 'like', '%'. $region .'%');
            });
        })->when($filters['city'] ?? null, function (Builder $query, string $city) {
            return $query->whereHas('city', function (Builder $query) use ($city) {
                return $query->orWhere('city', 'like', '%'. $city .'%');
            });
        })->when($filters['address'] ?? null, function (Builder $query, string $address) {
            return $query->whereHas('address', function (Builder $query) use ($address){
                return $query->orWhere('address', 'like', '%' . $address . '%');
            });
        })->when($filters['creator'] ?? null, function (Builder $query, string $creator) {
            return $query->whereHas('creator', function (Builder $query) use ($creator) {
                return $query->where('login', 'like', '%'. $creator .'%')
                    ->orWhere('email', 'like', '%'. $creator .'%')
                    ->orWhere('profile->first_name', 'like', '%'. $creator .'%')
                    ->orWhere('profile->middle_name', 'like', '%'. $creator .'%')
                    ->orWhere('profile->last_name', 'like', '%'. $creator .'%');
            });
        });
    }
}
