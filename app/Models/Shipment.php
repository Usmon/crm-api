<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Shipment
 *
 * @property int $id
 *
 * @property string $name
 *
 * @property integer $creator_id
 *
 * @property string $status_id
 *
 * @property integer $total_boxes
 *
 * @property double $total_weight_boxes
 *
 * @property integer $total_price_orders
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read HasOne|null $status
 *
 * @property-read HasMany|null $orders
 *
 * @property-read HasOne|null $creator
 *
 * @property-read int $total_orders
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Shipment extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'shipments';

    /**
     * @var array
     */
    protected $fillable = [
        'name',

        'box_id',

        'creator_id',

        'status_id',

        'deleted_by',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'name' => 'string',

        'box_id' => 'integer',

        'creator_id' => 'integer',

        'status_id' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class)->with(['boxes']);
    }

    /**
     * @return int
     */
    public function getTotalBoxesAttribute(): int
    {
        return $this->orders()->sum('total_boxes');
    }



    /**
     * @return float
     */
    public function getTotalWeightBoxesAttribute(): float
    {
        return $this->orders()->sum('total_weight_boxes');
    }

    /**
     * @return float
     */
    public function getTotalPriceOrdersAttribute(): float
    {
        return $this->orders()->sum('price');
    }

    /**
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    /**
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }

    /**
     * @return int
     */
    public function getTotalOrdersAttribute(): int
    {
        return $this->orders()->count();
    }

    /**
     * @return array
     */
    public function creatorPhones(): array
    {
        return collect($this->creator()->first()->phones()
            ->latest('id')
            ->limit(3)
            ->get(['phone'])
            ->toArray())
            ->flatten()
            ->all();
    }

    /**
     * @return string
     */
    public function creatorName(): string
    {
        return $this->creator->profile['first_name']
            . ' ' . $this->creator->profile['last_name']
            . ' ' . $this->creator->profile['middle_name'];
    }

    /**
     * @return string
     */
    public function statusColorBg(): string
    {
        return $this->status->parameters['color']['bg'];
    }

    /**
     * @return string
     */
    public function statusColorText(): string
    {
        return $this->status->parameters['color']['text'];
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
     * @return HasMany
     */
    public function boxes(): HasMany
    {
        return $this->hasMany(Box::class);
    }

    /**
     * @return int
     */
    public function totalCustomers(): int
    {
        return $this->orders()->distinct('sender_id')->count();
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
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['name'] ?? null, function (Builder $query, string $name) {
            return $query->where('name', 'like', '%'. $name .'%');
        });
    }
}
