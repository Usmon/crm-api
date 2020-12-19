<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Project
 *
 * @property int $id
 *
 * @property string $name
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property integer|null $deleted_by
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Project extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'projects';

    /**
     * @var array
     */
    protected $fillable = [
        'name',

        'deleted_by'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'name' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer'
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
                return $query->where('name', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['name'] ?? null, function (Builder $query, $name){
            return $query->where('name', 'like', '%' . $name . '%');
        });
    }
}
