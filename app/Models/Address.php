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
 * @property integer $customer_id
 *
 * @property integer $city_id
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
 * @property-read HasOne|null $customer
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
        'customer_id',

        'city_id',

        'first_address',

        'second_address',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'customer_id' => 'integer',

        'city_id' => 'integer',

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
    public function customer():HasOne
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }

    /**
     * @return HasOne
     */
    public function city():HasOne
    {
        return $this->hasOne(City::class,'id','city_id');
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
        })->when($filters['customer_id'] ?? null, function (Builder $query, int $customer_id){
            return $query->where('customer_id','=', $customer_id);
        })->when($filters['city_id'] ?? null, function (Builder $query, int $city_id){
            return $query->where('city_id','=', $city_id);
        })->when($filters['customer'] ?? null, function (Builder $query, string $customer) {
            return $query->whereHas('customer', function (Builder $query) use ($customer) {
                $query->where('passport', 'like', '%' . $customer . '%')
                    ->orWhere('note', 'like', '%' . $customer . '%');
            });
        })->when($filters['city'] ?? null, function (Builder $query, string $city) {
            return $query->whereHas('city', function (Builder $query) use ($city) {
                $query->where('name', 'like', '%' . $city . '%');
            });
        });
    }
}
