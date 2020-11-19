<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Role
 *
 * @property int $id
 *
 * @property string $name
 *
 * @property string $slug
 *
 * @property string|null $description
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|User[] $users
 *
 * @property-read Collection|Permission[] $permissions
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @mixin Model
 */
final class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @var array
     */
    protected $fillable = [
        'name',

        'slug',

        'description',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'name' => 'string',

        'slug' => 'string',

        'description' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role')->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission')->withTimestamps();
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
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['user'] ?? null, function (Builder $query, int $user) {
            return $query->whereHas('users', function (Builder $query) use ($user) {
                return $query->where('id', '=', $user);
            });
        })->when($filters['permission'] ?? null, function (Builder $query, int $permission) {
            return $query->whereHas('permissions', function (Builder $query) use ($permission) {
                return $query->where('id', '=', $permission);
            });
        });
    }
}
