<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Traits\Pagination\Pager;

/**
 * App\Models\Pickup
 *
 * @property int $id
 *
 * @property string $note
 *
 * @property int $bring_address
 *
 * @property Carbon $bring_datetime_start
 *
 * @property Carbon $bring_datetime_end
 *
 * @property int staff_id
 *
 * @property int driver_id
 *
 * @property int customer_id
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|User[] $users
 *
 * @property-read Collection|Order[] $orders
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Pickup extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Pager;

    /**
     * @var string
     */
    protected $table = 'pickups';

    /**
     * @var array
     */
    protected $fillable = [
      'note',

      'bring_address',

      'bring_datetime_start',

      'bring_datetime_end',

      'staff_id',

      'driver_id',

      'customer_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'note' => 'string',

        'bring_address' => 'integer',

        'bring_datetime_start' => 'datetime',

        'bring_datetime_end' => 'datetime',

        'staff_id' => 'integer',

        'driver_id' => 'integer',

        'customer_id' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        return $query->when($filters['search'] ?? null, function (Builder $query, string $search)
        {
            return $query->where(function (Builder $query) use ($search)
            {
                return $query->where('note', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date)
        {
            return $query->whereBetween('created_at', $date);
        });
    }

}
