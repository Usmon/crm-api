<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Permission
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
 * @property-read Collection|Role[] $roles
 *
 * @mixin Model
 */
final class Permission extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'permissions';

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
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission')->withTimestamps();
    }
}
