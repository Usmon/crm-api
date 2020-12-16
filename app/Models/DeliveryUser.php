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
 * App\Models\DeliveryUser
 *
 * @property integer $user_id
 *
 * @property integer $delivery_id
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property integer|null $deleted_by
 *
 * @property-read HasOne $user
 *
 * @property-read HasOne $delivery
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class DeliveryUser extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'delivery_users';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',

        'delivery_id',

        'deleted_by'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',

        'delivery_id' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_by' => 'integer'
    ];

    /**
     * @return HasOne
     */
    public function user():HasOne
    {
        return $this->hasOne(User::class,'id', 'user_id');
    }
    /**
     * @return HasOne
     */
    public function delivery():HasOne
    {
        return $this->hasOne(Delivery::class,'id','delivery_id');
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
        return $query->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['user_id'] ?? null, function (Builder $query, $user_id){
            return $query->where('user_id', '=', $user_id);
        })->when($filters['delivery_id'] ?? null, function (Builder $query, $delivery_id){
            return $query->where('delivery_id', '=', $delivery_id);
        });
    }
}
