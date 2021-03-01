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
        return $this->hasOne(User::class,'id','user_id')->with(['phones']);
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
                return $query->orWhere('car_model', 'like', '%'. $search .'%')
                    ->orWhere('car_number', 'like', '%'. $search .'%')
                    ->orWhere('license', 'like', '%'. $search .'%');
            });
        })->when($filters['car_model'] ?? null, function (Builder $query, string $carModel) {
            return $query->orWhere('car_model', 'like', '%' . $carModel . '%');
        })->when($filters['car_number'] ?? null, function (Builder $query, string $carNumber) {
            return $query->orWhere('car_number', 'like', '%' . $carNumber . '%');
        })->when($filters['license'] ?? null, function (Builder $query, string $license) {
            return $query->orWhere('license', 'like', '%' . $license . '%');
        })->when($filters['creator'] ?? null, function (Builder $query, string $creator) {
            return $query->whereHas('creator', function (Builder $query) use ($creator) {
                return $query->orWhere('login', 'like', '%'. $creator .'%')
                    ->orWhere('email', 'like', '%'. $creator .'%')
                    ->orWhere('profile->first_name', 'like', '%'. $creator .'%')
                    ->orWhere('profile->middle_name', 'like', '%'. $creator .'%')
                    ->orWhere('profile->last_name', 'like', '%'. $creator .'%');
            });
        })->when($filters['user'] ?? null, function (Builder $query, string $user) {
            return $query->whereHas('user', function (Builder $query) use ($user) {
                return $query->whereHas('phones', function (Builder $query) use ($user) {
                    return $query->where('phone', 'like', '%'. $user .'%');
                })->orWhere('login', 'like', '%'. $user .'%')
                    ->orWhere('email', 'like', '%'. $user .'%')
                    ->orWhere('profile->first_name', 'like', '%'. $user .'%')
                    ->orWhere('profile->middle_name', 'like', '%'. $user .'%')
                    ->orWhere('profile->last_name', 'like', '%'. $user .'%');
            });
        });
    }
}
