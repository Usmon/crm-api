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
 * Class Tracking
 *
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $tracking
 *
 * @property integer $customer_id
 *
 * @property integer|null $item
 *
 * @property string|null $color
 *
 * @property integer|null $QTN
 *
 * @property integer|null $box_id
 *
 * @property string|null $image
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property integer $deleted_by
 *
 * @property-read HasOne|null $customer
 *
 * @property-read HasOne|null $box
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Tracking extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'trackings';

    /**
     * @var array
     */
    protected $fillable = [
        'tracking',

        'customer_id',

        'item',

        'color',

        'QTN',

        'box_id',

        'image',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'tracking' => 'string',

        'customer_id' => 'integer',

        'item' => 'integer',

        'color' => 'string',

        'QTN' => 'integer',

        'box_id' => 'integer',

        'image' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer',
    ];

    /**
     * @return HasOne
     */
    public function customer():HasOne
    {
        return $this->hasOne(Customer::class,'id','customer_id')->with(['user']);
    }

    /**
     * @return HasOne
     */
    public function box():HasOne
    {
        return $this->hasOne(Box::class,'id','box_id');
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
                return $query->where('tracking', 'like', '%' . $search . '%');
            });
        })->when($filters['tracking'] ?? null, function (Builder $query, string $tracking) {
            $query->where('tracking', 'like', '%'. $tracking .'%');
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['customer'] ?? null, function (Builder $query, string $customer) {
            return $query->whereHas('customer', function (Builder $query) use ($customer) {
                    $query->whereHas('user', function (Builder $query) use ($customer) {
                        $query->where('login', 'like', '%' . $customer . '%')
                            ->orWhere('email', 'like', '%' . $customer . '%')
                            ->orWhere('profile', 'like', '%' . $customer . '%');
                })->orWhere('passport', 'like', '%' . $customer . '%')
                    ->orWhere('note', 'like', '%' . $customer . '%');
            });
        });
    }
}
