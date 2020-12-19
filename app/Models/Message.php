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
 * App\Models\Message
 *
 * @property integer $sender_id
 *
 * @property integer $receiver_id
 *
 * @property string $body
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property integer|null $deleted_by
 *
 * @property-read HasOne|null $sender
 *
 * @property-read HasOne|null $receiver
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Message extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'messages';

    /**
     * @var array
     */
    protected $fillable = [
        'sender_id',

        'receiver_id',

        'body'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'sender_id' => 'integer',

        'receiver_id' => 'integer',

        'body' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer'
    ];

    /**
     * @return HasOne
     */
    public function sender():HasOne
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    /**
     * @return HasOne
     */
    public function receiver():HasOne
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
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
                return $query->where('body', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['body'] ?? null, function (Builder $query, string $body){
            return $query->where('body', 'like', '%'. $body .'%');
        })->when($filters['sender_id'] ?? null, function (Builder $query, int $sender_id){
            return $query->where('sender_id', '=', $sender_id);
        })->when($filters['receiver_id'] ?? null, function (Builder $query, int $receiver_id){
            return $query->where('receiver_id', '=', $receiver_id);
        });
    }
}
