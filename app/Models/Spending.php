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
 * App\Models\Spending
 *
 * @property integer $id
 *
 * @property integer $creator_id
 *
 * @property double $amount
 *
 * @property integer $category_id
 *
 * @property string $note
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property integer|null $deleted_by
 *
 * @property-read HasOne|null $creator
 *
 * @property-read HasOne|null $category
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Spending extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'spendings';

    /**
     * @var array
     */
    protected $fillable = [
        'creator_id',

        'amount',

        'category_id',

        'note',

        'deleted_by'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'creator_id' => 'integer',

        'amount' => 'double',

        'category_id' => 'integer',

        'note' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer'
    ];

    /**
     * @return HasOne
     */
    public function category():HasOne
    {
        return $this->hasOne(SpendingCategory::class,'id', 'category_id');
    }

    /**
     * @return HasOne
     */
    public function creator():HasOne
    {
        return $this->hasOne(User::class,'id', 'creator_id');
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
                return $query->where('note', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['note'] ?? null, function (Builder $query, $note){
            return $query->where('note', 'like', '%' . $note . '%');
        })->when($filters['creator_id'] ?? null, function(Builder $query, int $creator_id){
            return $query->where('creator_id', '=', $creator_id);
        })->when($filters['category_id'] ?? null, function(Builder $query, int $category_id){
            return $query->where('category_id', '=', $category_id);
        })->when($filters['amount'] ?? null, function(Builder $query, array $amount){
            return $query->whereBetween('amount', $amount);
        });
    }
}
