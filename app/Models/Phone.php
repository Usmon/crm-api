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
 * App\Models\Phone
 *
 * @property integer $id
 *
 * @property integer $user_id
 *
 * @property string $phone
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
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Phone extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'phones';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',

        'phone'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',

        'phone' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer',
    ];

    /**
     * @return HasOne
     */
    protected function user(): HasOne
    {
        return $this->hasOne(Customer::class,'id','user_id');
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
                return $query->where('phone', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['phone'] ?? null, function (Builder $query, string $phone){
            return $query->where('phone','like','%'. $phone .'%');
        })->when($filters['user_id'] ?? null, function (Builder $query, int $customer_id){
            return $query->where('user_id','=', $customer_id);
        })->when($filters['user'] ?? null, function (Builder $query, string $user) {
            return $query->whereHas('user', function (Builder $query) use ($user) {
                $query->where('login', 'like', '%' . $user . '%')
                    ->orWhere('email', 'like', '%' . $user . '%');
            });
        });
    }
}
