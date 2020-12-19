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
 * App\Models\ShipmentComment
 *
 * @property int $id
 *
 * @property integer $shipment_id
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
 * @property-read HasOne|null $shipment
 *
 * @property-read HasOne|null $owner
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class ShipmentComment extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'shipment_comments';

    /**
     * @var array
     */
    protected $fillable = [
        'shipment_id',

        'owner_id',

        'comment'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'shipment_id' => 'integer',

        'owner_id' => 'integer',

        'comment' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer'
    ];

    /**
     * @return HasOne
     */
    public function shipment():HasOne
    {
        return $this->hasOne(Shipment::class, 'id', 'shipment_id');
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
        })->when($filters['comment'] ?? null, function (Builder $query, string $comment) {
            return $query->where('comment', 'like', '%'. $comment .'%');
        })->when($filters['shipment_id'] ?? null, function (Builder $query, int $shipment_id) {
            return $query->where('shipment_id', '=', $shipment_id);
        })->when($filters['owner_id'] ?? null, function (Builder $query, int $owner_id) {
            return $query->where('owner_id', '=', $owner_id);
        });
    }
}
