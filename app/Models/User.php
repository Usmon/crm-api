<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Models\Foundation\Auth;
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
}
