<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Token
 *
 * @property int $id
 * @property string $value
 * @property array $device
 * @property int $user_id
 * @property Carbon|null $used_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @mixin Model
 */
final class Token extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'tokens';

    /**
     * @var array
     */
    protected $fillable = [
        'value',
        'device',
        'user_id',
        'used_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'value' => 'string',
        'device' => 'array',
        'used_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
