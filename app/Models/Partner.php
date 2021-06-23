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
 * App\Models\Address
 *
 * @property integer $id
 *
 * @property integer $city_id
 *
 * @property string $name
 *
 * @property string $description
 *
 * @property string $address
 *
 * @property string $photo
 *
 * @property string $phone
 *
 * @property integer $creator_id
 *
 * @property float $weight_price
 *
 * @property float $warehouse_price
 *
 * @property float $delivery
 *
 * @property float $pickup
 *
 * @property float $discount_price
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property int|null $deleted_by
 *
 * @property-read HasOne|null $city
 *
 * @property-read HasOne|null $user
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Partner extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'partners';

    /**
     * @var array
     */
    protected $fillable = [
        'city_id',

        'name',

        'address',

        'phone',

        'description',

        'creator_id',

        'weight_price',

        'warehouse_price',

        'pickup',

        'delivery',

        'discount_price',

        'photo'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'city_id' => 'integer',

        'name' => 'string',

        'address' => 'string',

        'phone' => 'string',

        'description' => 'string',

        'creator_id' => 'integer',

        'weight_price' => 'float',

        'warehouse_price' => 'float',

        'pickup' => 'float',

        'delivery' => 'float',

        'discount_price' => 'float',

        'photo' => 'string'
    ];

    /**
     * @return HasOne
     */
    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
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
                return $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('description', 'like', '%'.$search.'%')
                            ->orWhere('address', 'like', '%'.$search.'%')
                            ->orWhere('phone', 'like', '%'.$search.'%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['name'] ?? null, function (Builder $query, string $name){
            return $query->where('name','like','%'. $name .'%');
        })->when($filters['address'] ?? null, function (Builder $query, string $address){
            return $query->where('address','like','%'. $address .'%');
        })->when($filters['description'] ?? null, function (Builder $query, string $description){
            return $query->where('description','like','%'. $description .'%');
        })->when($filters['phone'] ?? null, function (Builder $query, string $phone){
            return $query->where('phone','like','%'. $phone .'%');
        })->when($filters['city_id'] ?? null, function (Builder $query, int $city_id){
            return $query->where('city_id','=', $city_id);
        })->when($filters['city'] ?? null, function (Builder $query, string $city) {
            return $query->whereHas('city', function (Builder $query) use ($city) {
                $query->where('name', 'like', '%' . $city . '%');
            });
        });
    }
}
