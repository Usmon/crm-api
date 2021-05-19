<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Support\Facades\Date;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Customer
 *
 * @property integer $id
 *
 * @property integer $user_id
 *
 * @property integer $creator_id
 *
 * @property integer $referral_id
 *
 * @property string $passport
 *
 * @property double $balance
 *
 * @property double $debt
 *
 * @property double $limit
 *
 * @property Date $birth_date
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
 * @property-read array $passport_serialize
 *
 * @property-read HasOne|User $user
 *
 * @property-read HasOne|Customer $customer
 *
 * @property-read HasOne  $creator
 *
 * @property-read HasOne  $referral
 *
 * @property-read HasMany $phones
 *
 * @property-read HasOne $sender
 *
 * @property-read HasOne $recipient
 *
 * @property-read HasMany $addresses
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Customer extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'customers';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',

        'creator_id',

        'referral_id',

        'passport',

        'balance',

        'debt',

        'limit',

        'birth_date',

        'note',

        'deleted_by'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'user_id' => 'integer',

        'creator_id' => 'integer',

        'referral_id' => 'integer',

        'passport' => 'string',

        'birth_date' => 'date',

        'balance' => 'double',

        'debt' => 'double',

        'limit' => 'double',

        'note' => 'string',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',

        'deleted_by' => 'integer',
    ];

    /**
     * @return HasOne
     */
    public function user():HasOne
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    /**
     * @return HasOne
     */
    public function creator():HasOne
    {
        return $this->hasOne(User::class, 'id','creator_id');
    }

    /**
     * @return HasOne
     */
    public function referral():HasOne
    {
        return $this->hasOne(User::class, 'id','referral_id');
    }

    /**
     * @return HasOne
     */
    public function sender(): HasOne
    {
        return $this->hasOne(Sender::class);
    }

    /**
     * @return HasOne
     */
    public function recipient(): HasOne
    {
        return $this->hasOne(Recipient::class);
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
                return $query->where('passport', 'like', '%' . $search . '%')
                    ->orWhere('note', 'like', '%' . $search . '%');
            })->orWhereHas('user', function(Builder $query) use ($search) {
                return $query->where('full_name', 'like', '%'.$search.'%')
                        ->orWhereHas('phones', function (Builder $query) use($search) {
                            return $query->where('phone', 'like', '%'.$search.'%');
                        });
            });
        })->when($filters['user_id'] ?? null, function (Builder $query, int $user_id) {
            return $query->where('user_id', '=', $user_id);
        })->when($filters['creator_id'] ?? null, function (Builder $query, int $creator_id) {
            return $query->where('creator_id', '=', $creator_id);
        })->when($filters['referral_id'] ?? null, function (Builder $query, int $referral_id) {
            return $query->where('referral_id', '=', $referral_id);
        })->when($filters['passport'] ?? null, function (Builder $query, string $passport) {
            return $query->where('passport', 'like', '%'. $passport .'%');
        })->when($filters['balance'] ?? null, function (Builder $query, array $balance) {
            return $query->whereBetween('balance', $balance);
        })->when($filters['debt'] ?? null, function (Builder $query, array $debt) {
            return $query->whereBetween('debt', $debt);
        })->when($filters['birth_date'] ?? null, function (Builder $query, array $birthDate) {
            return $query->whereBetween('birth_date', $birthDate);
        })->when($filters['note'] ?? null, function (Builder $query, string $note) {
            return $query->where('note', 'like', '%'. $note .'%');
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['phone'] ?? null, function (Builder $query, string $phone) {
            return $query->whereHas('user', function (Builder $query) use ($phone) {
               return $query->whereHas('phones', function (Builder $query) use ($phone) {
                   return $query->where('phone', 'like', '%'. $phone .'%');
               });
            });
        });
    }

    /**
     * @param Builder $query
     *
     * @param bool $is_recipient
     *
     * @return Builder
     */
    public function scopeSenderOrRecipient(Builder $query, bool $is_recipient): Builder
    {
        if ($is_recipient)
            return $query->has('recipient');

        return $query->has('sender');
    }

    /**
     * @return array
     */
    public function getPassportSerializeAttribute(): array
    {
        return [
            'serial' => strtoupper(substr($this->passport, '0', 2)),

            'number' => (int) substr($this->passport, '2'),
        ];
    }
}
