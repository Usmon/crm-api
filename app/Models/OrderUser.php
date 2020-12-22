<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\OrderUser
 *
 * @property int $id
 *
 * @property int $user_id
 *
 * @property int $order_id
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property int|null deleted_by
 *
 * @property-read HasOne|null $user
 *
 * @property-read HasOne|null $order
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */

final class OrderUser extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'order_users';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',

        'order_id',

        'deleted_by'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',

        'order_id' => 'integer',

        'deleted_by' => 'integer'
    ];

    /**
     * @return HasOne
     */
    public function user():HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function order():HasOne
    {
        return $this->hasOne(Order::class,'id','order_id');
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
        return $query->when($filters['date'] ?? null, function (Builder $query, array $date){
            return $query->whereBetween('created_at',$date);
        })->when($filters['user_id'] ?? null, function (Builder $query, int $user_id){
            return $query->where('user_id','=',$user_id);
        })->when($filters['order_id'] ?? null, function (Builder $query, int $order_id){
            return $query->where('order_id','=', $order_id);
        });
    }
}
