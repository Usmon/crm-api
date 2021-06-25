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
 * App\Models\Address
 *
 * @property integer $id
 *
 * @property integer $user_id
 *
 * @property integer $city_id
 *
 * @property integer $code
 *
 * @property string $first_address
 *
 * @property string $second_address
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property int|null $deleted_by
 *
 * @property-read HasOne|null $user
 *
 * @property-read HasOne|null $city
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Address extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'addresses';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',

        'city_id',

        'first_address',

        'second_address',

        'code'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',

        'city_id' => 'integer',

        'code' => 'integer',

        'first_address' => 'string',

        'second_address' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer',
    ];

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
    public function city(): HasOne
    {
        return $this->hasOne(City::class,'id','city_id')->with('region');
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
                return $query->where('first_address', 'like', '%' . $search . '%')
                            ->orWhere('second_address', 'like', '%'.$search.'%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['first_address'] ?? null, function (Builder $query, string $first_address){
            return $query->where('first_address','like','%'. $first_address .'%');
        })->when($filters['second_address'] ?? null, function (Builder $query, string $second_address){
            return $query->where('second_address','like','%'. $second_address .'%');
        })->when($filters['user_id'] ?? null, function (Builder $query, int $customer_id){
            return $query->where('user_id','=', $customer_id);
        })->when($filters['city_id'] ?? null, function (Builder $query, int $city_id){
            return $query->where('city_id','=', $city_id);
        })->when($filters['user'] ?? null, function (Builder $query, string $user) {
            return $query->whereHas('user', function (Builder $query) use ($user) {
                $query->where('login', 'like', '%' . $user . '%')
                    ->orWhere('email', 'like', '%' . $user . '%')
                    ->orWhere('profile->first_name', 'like', '%' . $user . '%')
                    ->orWhere('profile->middle_name', 'like', '%' . $user . '%')
                    ->orWhere('profile->last_name', 'like', '%' . $user . '%')
                ;
            });
        })->when($filters['city'] ?? null, function (Builder $query, string $city) {
            return $query->whereHas('city', function (Builder $query) use ($city) {
                $query->where('name', 'like', '%' . $city . '%');
            });
        });
    }
}
