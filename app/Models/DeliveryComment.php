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
 * App\Models\DeliveryComment
 *
 * @property integer $id
 *
 * @property integer $delivery_id
 *
 * @property integer $owner_id
 *
 * @property string $comment
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property integer|null $deleted_by
 *
 * @property-read HasOne|null $delivery
 *
 * @property-read HasOne|null $owner
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class DeliveryComment extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'delivery_comments';

    /**
     * @var array
     */
    protected $fillable = [
        'delivery_id',

        'owner_id',

        'comment',

        'deleted_by'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'delivery_id' => 'integer',

        'owner_id' => 'integer',

        'comment' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_by' => 'integer'
    ];

    /**
     * @return HasOne
     */
    public function delivery():HasOne
    {
        return $this->hasOne(Delivery::class, 'id', 'delivery_id');
    }

    /**
     * @return HasOne
     */
    public function owner():HasOne
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
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
                return $query->where('comment', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['comment'] ?? null, function (Builder $query, string $comment){
            return $query->where('comment', 'like', '%' . $comment . '%');
        })->when($filters['delivery_id'] ?? null, function (Builder $query, int $delivery_id){
            return $query->where('delivery_id', '=', $delivery_id);
        })->when($filters['owner_id'] ?? null, function (Builder $query, int $owner_id){
            return $query->where('owner_id', '=', $owner_id);
        });
    }
}
