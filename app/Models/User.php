<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use App\Models\Foundation\Auth;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $login
 * @property string $email
 * @property string $password
 * @property array $profile
 * @property string|null $reset_token
 * @property string|null $verify_token
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|Role[] $roles
 * @property-read Collection|Token[] $tokens
 *
 * @mixin User
 */
final class User extends Auth
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = [
        'login',
        'email',
        'password',
        'profile',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'reset_token',
        'verify_token',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'login' => 'string',
        'email' => 'string',
        'password' => 'string',
        'profile' => 'array',
        'reset_token' => 'string',
        'verify_token' => 'string',
        'remember_token' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * @var array
     */
    public const DEFAULT_PROFILE = [
        'first_name'=> null,
        'middle_name' => null,
        'last_name' => null,
        'photo' => null,
    ];

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * @return HasMany
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }
}
