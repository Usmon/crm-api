<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Region
 *
 * @property integer $id
 *
 * @property integer $country_id
 *
 * @property string $name
 *
 * @property string $code
 *
 * @property string $zip_code
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property integer $deleted_by
 *
 * @property-read HasMany|null $cities
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Region extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Sorter;
    use Pager;

    /**
     * @var string
     */
    protected $table = 'regions';

    /**
     * @var array
     */
    protected $fillable = [
        'name',

        'zip_code',

        'code',

        'country_id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'string',

        'code' => 'string',

        'zip_code' => 'string',

        'country_id' => 'int'
    ];

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
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
                    ->orWhere('zip_code','like','%'. $search .'%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
                return $query->whereBetween('created_at', $date);
        })->when($filters['name'] ?? null, function (Builder $query, string $name){
                return $query->where('name', 'like', '%'. $name .'%');
        })->when($filters['zip_code'] ?? null, function (Builder $query, string $zipCode) {
            return $query->where('zip_code', 'like', '%' . $zipCode . '%');
        })->when($filters['country_code'] ?? null, function(Builder $query, string $code) {
            return $query->whereHas('country', function(Builder $query) use ($code) {
                return $query->where('code', '=', $code);
            });
        });
    }
}
