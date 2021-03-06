<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Token
 *
 * @property int $id
 *
 * @property string $value
 *
 * @property array $device
 *
 * @property int $user_id
 *
 * @property Carbon|null $used_at
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read User $user
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @mixin Model
 */
final class Token extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    /**
     * @var array
     */
    public const DEFAULT_DEVICE = [
        'ip' => null,

        'os' => null,

        'type' => null,

        'name' => null,
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
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
}
