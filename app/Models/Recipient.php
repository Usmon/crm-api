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
 * App\Models\Recipient
 *
 * @property integer $id
 *
 * @property integer $customer_id
 *
 * @property string $address
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read HasOne|null $customer
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Recipient extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;
    use Sorter;

    /**
     * @var string
     */
    protected $table = 'recipients';

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

        'address' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime'
    ];

    /**
     * @return HasOne
     */
    public function customer():HasOne
    {
        return $this->hasOne(User::class,'id', 'customer_id');
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
        })->when($filters['address'] ?? null, function (Builder $query, $address){
            return $query->where('address', 'like', '%'. $address .'%');
        })->when($filters['customer_id'] ?? null, function (Builder $query, int $customer_id){
            return $query->where('customer_id', '=', $customer_id);
        })->when($filters['customer'] ?? null, function (Builder $query, string $customer) {
            return $query->whereHas('customer', function (Builder $query) use ($customer) {
                $query->orWhere('login', 'like', '%' . $customer . '%')
                    ->orWhere('email', 'like', '%' . $customer . '%')
                    ->orWhere('profile', 'like', '%' . $customer . '%');
            });
        });
    }
}
