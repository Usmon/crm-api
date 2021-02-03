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
 * @property string $name
 *
 * @property string $phone
 *
 * @property string $email
 *
 * @property string $region
 *
 * @property string $city
 *
 * @property string $zip_or_post_code
 *
 * @property string $address
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

        'name',

        'phone',

        'email',

        'region',

        'city',

        'zip_or_post_code',

        'address',

        'car_model',

        'car_number',

        'license',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'creator_id' => 'integer',

        'name' => 'string',

        'phone' => 'string',

        'email' => 'string',

        'region' => 'string',

        'city' => 'string',

        'zip_or_post_code' => 'string',

        'address' => 'string',

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
                return $query->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%'. $search .'%')
                    ->orWhere('email', 'like', '%'. $search .'%')
                    ->orWhere('car_model', 'like', '%'. $search .'%')
                    ->orWhere('car_number', 'like', '%'. $search .'%')
                    ->orWhere('license', 'like', '%'. $search .'%')
                    ->orWhere('region', 'like', '%'. $search .'%')
                    ->orWhere('city', 'like', '%'. $search .'%')
                    ->orWhere('zip_or_post_code', 'like', '%'. $search .'%')
                    ->orWhere('address', 'like', '%'. $search .'%')
                    ->whereHas('creator', function (Builder $query) use ($search) {
                        $query->orWhere('login', 'like', '%'. $search .'%')
                            ->orWhere('email', 'like', '%'. $search .'%')
                            ->orWhere('profile->first_name', 'like', '%'. $search .'%')
                            ->orWhere('profile->middle_name', 'like', '%'. $search .'%')
                            ->orWhere('profile->last_name', 'like', '%'. $search .'%');
                    });
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
        })->when($filters['region'] ?? null, function (Builder $query, string $region) {
            return $query->orWhere('region', 'like', '%'. $region .'%');
        })->when($filters['city'] ?? null, function (Builder $query, string $city) {
            return $query->orWhere('city', 'like', '%'. $city .'%');
        })->when($filters['zip_or_post_code'] ?? null, function (Builder $query, string $zipOrPostCode) {
            return $query->orWhere('zip_or_post_code', 'like', '%'. $zipOrPostCode .'%');
        })->when($filters['address'] ?? null, function (Builder $query, string $address) {
            return $query->orWhere('address', 'like', '%'. $address .'%');
        })->when($filters['creator'] ?? null, function (Builder $query, string $creator) {
            return $query->whereHas('creator', function (Builder $query) use ($creator) {
               return $query->where('login', 'like', '%'. $creator .'%')
                   ->orWhere('email', 'like', '%'. $creator .'%')
                   ->orWhere('profile', 'like', '%'. $creator .'%');
            });
        });
    }
}
