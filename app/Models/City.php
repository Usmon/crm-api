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
 * App\Models\City
 *
 * @property integer $id
 *
 * @property integer region_id
 *
 * @property string $name
 *
 * @property array $codes
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property int|null $deleted_by
 *
 * @property-read HasOne $region
 *
 * @property-read HasMany $addresses
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */

final class City extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;


    /**
     * @var string
     */
    protected $table = 'cities';

    /**
     * @var array
     */
    protected $fillable = [
        'region_id',

        'name',

        'codes'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'region_id' => 'integer',

        'name' => 'string',

        'codes' => 'array',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    /**
     * @return HasOne
     */
    public function region(): HasOne
    {
        return $this->hasOne(Region::class,'id','region_id');
    }

    /**
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
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
                return $query->where('name', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['name'] ?? null, function (Builder $query, string $name){
            return $query->where('name','like','%'.$name.'%');
        })->when($filters['region_id'] ?? null, function (Builder $query, int $region_id){
            return $query->where('region_id', '=', $region_id);
        })->when($filters['region'] ?? null, function (Builder $query, string $region) {
            return $query->whereHas('region', function (Builder $query) use ($region) {
               return $query->where('name','like','%'. $region .'%')
                   ->orWhere('zip_code','like','%'. $region .'%');
            });
        })->when($filters['code'] ?? null, function (Builder $query, int $code) {
            return $query->whereJsonContains('codes', $code);
        });
    }
}
