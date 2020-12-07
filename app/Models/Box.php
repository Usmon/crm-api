<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Traits\Pagination\Pager;

/**
 * App\Models\Box
 *
 * @property int $id
 *
 * @property int $order_id
 *
 * @property int $customer_id
 *
 * @property int $sender_id
 *
 * @property int $recipient_id
 *
 * @property float $weight
 *
 * @property float $additional_weight
 *
 * @property string $status
 *
 * @property string $box_image
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 */

final class Box extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Pager;

    /**
     * @var string
     */
    protected $table = 'boxes';

    /**
     * @var array
     */
    protected $fillable = [
        'order_id',

        'customer_id',

        'sender_id',

        'recipient_id',

        'weight',

        'additional_weight',

        'status',

        'box_image',

    ];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'order_id' => 'integer',

        'customer_id' => 'integer',

        'sender_id' => 'integer',

        'recipient_id' => 'integer',

        'weight' => 'float',

        'additional_weight' => 'float',

        'status' => 'string',

        'box_image' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function senders(): BelongsTo
    {
        return $this->belongsTo(Sender::class);
    }

    /**
     * @return BelongsTo
     */
    public function recipients(): BelongsTo
    {
        return $this->belongsTo(Recipient::class);
    }

    /**
     * @return HasMany
     */
    public function box_items(): HasMany
    {
        return $this->hasMany(BoxItem::class);
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
                return $query->where('status', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['status'] ?? null, function (Builder $query, string $search){
            return $query->where('status','like','%'. $search .'%');
        })->when($filters['weight'] ?? null, function (Builder $query, float $weight){
            return $query->where('weight','=',$weight);
        })->when($filters['additional_weight'] ?? null, function (Builder $query, float $additional_weight){
            return $query->where('additional_weight','=',$additional_weight);
        });
    }
}
