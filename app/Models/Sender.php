<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Ramsey\Collection\Collection;

/**
 * App\Models\Sender
 *
 * @property integer $id
 *
 * @property integer $customer_id
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection $customer
 *
 * @property-read Collection $orders
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @method static Builder|self filterPhone(string $phone)
 *
 * @mixin Model
 */
final class Sender extends Model
{
    use Pager;
    use HasFactory;
    use SoftDeletes;
    use Sorter;

    /**
     * @var string
     */
    protected $table = 'senders';

    /**
     * @var array
     */
    protected $fillable = [
        'customer_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'customer_id' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime'
    ];

    /**
     * @return HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class,'id','customer_id')->with(['user.phones']);
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
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
        return $query->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['customer_id'] ?? null, function (Builder $query, int $customer_id) {
            return $query->where('customer_id', '=', $customer_id);
        })->when($filters['customer'] ?? null, function (Builder $query, string $customer) {
            return $query->whereHas('customer', function (Builder $query) use ($customer) {
                $query->whereHas('user', function (Builder $query) use ($customer) {
                    $query->whereHas('phones', function (Builder $query) use ($customer) {
                        return $query->where('phone', 'like', '%'. $customer .'%');
                    })->orWhere('login', 'like', '%' . $customer . '%')
                        ->orWhere('email', 'like', '%' . $customer . '%')
                        ->orWhere('profile', 'like', '%' . $customer . '%');
                })->orWhere('passport', 'like', '%' . $customer . '%')
                    ->orWhere('note', 'like', '%' . $customer . '%');
            });
        });
    }

    /**
     * @param Builder $query
     *
     * @param string $phone
     *
     * @return Builder
     */
    public function scopeFilterPhone(Builder $query, string $phone): Builder
    {
        return $query->when($phone ?? null, function (Builder $query, string $phone) {
            return $query->whereHas('customer', function (Builder $query) use ($phone) {
                $query->whereHas('user', function (Builder $query) use ($phone) {
                    $query->whereHas('phones', function (Builder $query) use ($phone) {
                        return $query->where('phone', 'like', '%'. $phone .'%');
                    });
                });
            });
        });
    }

    /**
     * @param string $phone
     *
     * @return string
     */
    public function getPhone(string $phone): string
    {
        return $this->customer->user->phones()->where('phone', 'like', '%'.$phone.'%')->first()->phone;
    }
}
