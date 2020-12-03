<?php

namespace App\Models;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Sender
 *
 * @property string $address
 *
 * @property integer $customer_id
 *
 * @property-read HasOne $customer
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

    /**
     * @var string
     */
    protected $table = 'senders';

    /**
     * @var array
     */
    protected $fillable = [
        'customer_id',

        'address'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'customer_id' => 'integer',

        'address' => 'string'
    ];

    /**
     * @return HasOne
     */
    protected function customer():HasOne
    {
        return $this->hasOne(User::class,'id');
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
                return $query->where('address', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['address'] ?? null, function (Builder $query, string $search){
            return $query->where('address','like','%'. $search .'%');
        });
    }
}
