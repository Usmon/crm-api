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

use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Traits\Pagination\Pager;

use App\Traits\Sort\Sorter;

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
 * @property int $status_id
 *
 * @property string $box_image
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

final class Box extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Pager;
    use Sorter;

    /**
     * @var string
     */
    protected $table = 'boxes';

    /**
     * @var array
     */
    protected $fillable = [
        'order_id',
        
        'status_id',

        'weight',

        'additional_weight',

        'status_id',

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

        'status_od' => 'integer',

        'weight' => 'float',

        'additional_weight' => 'float',

        'status_id' => 'integer',

        'box_image' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
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
     * @return HasMany
     */
    public function items(): HasMany
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
        })->when($filters['order_id'] ?? null, function (Builder $query, int $order_id){
            return $query->orWhere('order_id', '=', $order_id);
        })->when($filters['customer_id'] ?? null, function (Builder $query, int $customer_id){
            return $query->orWhere('customer_id', '=', $customer_id);
        })->when($filters['sender_id'] ?? null, function (Builder $query, int $sender_id){
            return $query->orWhere('sender_id', '=', $sender_id);
        })->when($filters['recipient_id'] ?? null, function (Builder $query, int $recipient_id){
            return $query->orWhere('recipient_id', '=', $recipient_id);
        })->when($filters['order'] ?? null, function (Builder $query, string $order){
            return $query->whereHas('order', function (Builder $query) use ($order){
                $query->where('status', 'like', '%'. $order. '%')
                    ->orWhere('payment_status', 'like', '%'. $order.'%');
            });
        })->when($filters['customer'] ?? null, function (Builder $query, string $customer) {
            return $query->whereHas('customer', function (Builder $query) use ($customer) {
                    $query->whereHas('user', function (Builder $query) use ($customer) {
                        $query->where('login', 'like', '%' . $customer . '%')
                            ->orWhere('email', 'like', '%' . $customer . '%')
                            ->orWhere('profile', 'like', '%' . $customer . '%');
                })->orWhere('passport', 'like', '%' . $customer . '%')
                    ->orWhere('note', 'like', '%' . $customer . '%');
            });
        })->when($filters['sender'] ?? null, function (Builder $query, string $sender){
            return $query->whereHas('sender', function (Builder $query) use ($sender){
                $query->where('address', 'like', '%'. $sender.'%');
            });
        })->when($filters['recipient'] ?? null, function (Builder $query, string $recipient){
            return $query->whereHas('sender', function (Builder $query) use ($recipient){
                $query->where('address', 'like', '%'.$recipient.'%');
            });
        })->when($filters['status'] ?? null, function (Builder $query, string $search){
            return $query->where('status','like','%'. $search .'%');
        })->when($filters['weight'] ?? null, function (Builder $query, float $weight){
            return $query->where('weight','=',$weight);
        })->when($filters['additional_weight'] ?? null, function (Builder $query, float $additional_weight){
            return $query->where('additional_weight','=',$additional_weight);
        });
    }
}
