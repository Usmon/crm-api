<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\OrderComment
 *
 * @property int $order_id
 *
 * @property int $owner_id
 *
 * @property string $comment
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property int|null $deleted_by
 *
 */
final class OrderComment extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'order_comments';

    /**
     * @var array
     */
    protected $fillable = [
        'order_id',

        'owner_id',

        'comment'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'order_id' => 'integer',

        'owner_id' => 'integer',

        'comment' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

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
        })->when($filters['comment'] ?? null, function (Builder $query, string $comment) {
            return $query->where('comment', 'like', '%'. $comment .'%');
        })->when($filters['order_id'] ?? null, function (Builder $query, int $order_id) {
            return $query->where('order_id', '=', $order_id);
        })->when($filters['owner_id'] ?? null, function (Builder $query, int $owner_id) {
            return $query->where('owner_id', '=', $owner_id);
        });
    }
}
