<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use App\Models\Foundation\Auth;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\Sort\Sorter;

use App\Traits\Pagination\Pager;
use phpDocumentor\Reflection\Types\Boolean;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 *
 * @property integer|null $partner_id
 *
 * @property string $login
 *
 * @property string $email
 *
 * @property string $password
 *
 * @property array $profile
 *
 * @property string|null $reset_token
 *
 * @property string|null $verify_token
 *
 * @property string|null $remember_token
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read string $short_info
 *
 * @property string $full_name
 *
 * @property-read string $avatar
 *
 * @property-read string $split_name
 *
 * @property-read Collection|Token[] $tokens
 *
 * @property-read Collection|Pickup[] $pickups
 *
 * @property-read Collection|Phone[] $phones
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @method static Builder|self filterFullName(string $key)
 *
 * @mixin Auth
 */
final class User extends Auth
{
    use HasFactory;
    use SoftDeletes;
    use Pager;
    use Sorter;
    use HasRoles;

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

        'partner_id',

        'full_name'
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

        'partner_id' => 'integer',

        'login' => 'string',

        'email' => 'string',

        'password' => 'string',

        'full_name' => 'string',

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
        'first_name' => null,

        'middle_name' => null,

        'last_name' => null,

        'photo' => null,
    ];

    /**
     * @return BelongsTo
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * @return HasMany
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }

    /**
     * @return HasMany
     */
    public function pickups(): HasMany
    {
        return $this->hasMany(Pickup::class, 'creator_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class, 'creator_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'staff_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class, 'creator_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * @return HasOne
     */
    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class);
    }

    /**
     * @param int $limit
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPhonesWithLimit(int $limit = 3): \Illuminate\Support\Collection
    {
        return collect($this->phones()->limit($limit)->get(['phone'])->toArray())->flatten();
    }

    /**
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class)->with(['city']);
    }

    /**
     * Get image if exists.
     *
     * @return string
     */
    public function getAvatarAttribute(): string
    {
        return $this->profile['photo'] ?? '';
    }

    /**
     * Get short info of user.
     *
     * @return array
     */
    public function getShortInfoAttribute(): array
    {
        return [
            'id' => $this->id,

            'name' => $this->full_name,

            'image' => $this->avatar,

            'phones' => $this->getPhonesWithLimit(3)
        ];
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
                return $query->where('login', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('full_name', 'like', '%' . $search . '%');
            });
        })->when($filters['username'] ?? null, function (Builder $query, string $username) {
            return $query->where('login', 'like', '%'.$username.'%');
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['only_corporate'] ?? null, function (Builder $query, bool $only_corporate) {
            return $query->whereDoesntHave('customer');
        });
    }

    /**
     * @return array
     */
    public function getSplitNameAttribute(): array
    {
        $result = explode(' ', $this->full_name);

        return [
            'first_name' => $result[0] ?? '',

            'middle_name' => $result[1] ?? '',

            'last_name' => $result[2] ?? '',
        ];
    }
}
