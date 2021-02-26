<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Support\Collection;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Delivery
 *
 * @property int $id
 *
 * @property int $recipient_id
 *
 * @property int $driver_id
 *
 * @property int $status_id
 *
 * @property int $creator_id
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @const STATUSES
 *
 * @property-read HasOne|null $recipient
 *
 * @property-read HasOne|null $driver
 *
 * @property-read HasOne|null $status
 *
 * @property-read HasOne|null $creator
 *
 * @property-read HasMany|null $orders
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 */

final class Delivery extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'deliveries';

    /**
     * @var array
     */
    protected $fillable = [
        'recipient_id',

        'driver_id',

        'status_id',

        'creator_id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'id' => 'integer',

        'recipient_id' => 'integer',

        'driver_id' => 'integer',

        'status_id' => 'integer',

        'creator_id' => 'integer',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];


    const STATUSES = [
        'pending',

        'delivered',

        'delivering',
    ];

    /**
     * @return HasOne
     */
    public function recipient(): HasOne
    {
        return $this->hasOne(Recipient::class,'id','customer_id')->with(['customer.user']);
    }

    /**
     * @return HasOne
     */
    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class, 'id', 'driver_id')->with(['user']);
    }

    /**
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    /**
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return int
     */
    public function totalDeliveredOrders(): int
    {
        return $this->orders->map(function (Order $order) {
            return $order->whereHas('status', function (Builder $query) {
                return $query->where('key', '=', 'delivered');
            })->count();
        })->sum();
    }

    /**
     * @return string
     */
    public function creatorName()
    {
        return $this->creator->profile['first_name'] . ' ' . $this->creator->profile['last_name'] . ' ' . $this->creator->profile['middle_name'];
    }

    /**
     * @return mixed
     */
    public function creatorImage()
    {
        return $this->creator->profile['photo'];
    }

    /**
     * @return Collection
     */
    public function creatorPhones(): Collection
    {
        return collect($this->creator->get()->first()->phones()
            ->latest('id')->limit(3)->get(['phone'])->toArray())
            ->flatten();
    }

    /**
     * @return string
     */
    public function driverName(): string
    {
        return $this->driver->user->profile['first_name']
            . ' ' . $this->driver->user->profile['last_name']
            . ' ' .$this->driver->user->profile['middle_name'];
    }

    /**
     * @return mixed
     */
    public function driverImage()
    {
        return $this->driver->user->profile['photo'];
    }

    /**
     * @return Collection
     */
    public function driverPhones(): Collection
    {
        return collect($this->driver->user->get()->first()->phones()
            ->latest('id')->limit(3)->get(['phone'])->toArray())
            ->flatten();
    }

    /**
     * @return int
     */
    public function totalProducts(): int
    {
        return $this->orders->map(function (Order $order) {
            return $order->products()->count();
        })->sum();
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
        })->when($filters['recipient_id'] ?? null, function (Builder $query, int $customerId) {
            return $query->where('recipient_id', '=', $customerId);
        })->when($filters['driver_id'] ?? null, function (Builder $query, int $driverId) {
            return $query->where('driver_id', '=', $driverId);
        })->when($filters['status_id'] ?? null, function (Builder $query, int $driverId) {
            return $query->where('status_id', '=', $driverId);
        })->when($filters['status'] ?? null, function (Builder $query, string $status) {
            return $query->whereHas('status', function (Builder $query) use ($status) {
                return $query->where('model', 'like', '%'. $status .'%')
                    ->orWhere('key', 'like', '%'. $status .'%')
                    ->orWhere('value', 'like', '%'. $status .'%')
                    ->orWhere('parameters', 'like', '%'. $status .'%');
            });
        })->when($filters['driver'] ?? null, function (Builder $query, string $driver) {
            return $query->whereHas('driver', function (Builder $query) use ($driver) {
                return $query->whereHas('user', function (Builder $query) use ($driver) {
                    return $query->whereHas('phones', function (Builder $query) use ($driver) {
                        return $query->where('phone', 'like', '%' . $driver . '%');
                    })->orWhere('login', 'like', '%' . $driver . '%')
                        ->orWhere('email', 'like', '%' . $driver . '%')
                        ->orWhere('profile', 'like', '%' . $driver . '%');
                });
            });
        })->when($filters['recipient'] ?? null, function (Builder $query, string $recipient) {
            return $query->whereHas('recipient', function (Builder $query) use ($recipient) {
                return $query->whereHas('customer', function (Builder $query) use ($recipient) {
                    return $query->whereHas('user', function (Builder $query) use ($recipient) {
                        return $query->whereHas('phones', function (Builder $query) use ($recipient) {
                            return $query->where('phone', 'like', '%' . $recipient . '%');
                        })->orWhere('login', 'like', '%' . $recipient . '%')
                            ->orWhere('email', 'like', '%' . $recipient . '%')
                            ->orWhere('profile', 'like', '%' . $recipient . '%');
                    });
                });
            });
        })->when($filters['creator'] ?? null, function (Builder $query, string $creator) {
            return $query->whereHas('creator', function (Builder $query) use ($creator) {
                return $query->where('login', 'like', '%' . $creator . '%')
                    ->orWhere('email', 'like', '%' . $creator .'%')
                    ->orWhere('profile', 'like', '%'. $creator .'%');
            });
        })->when($filters['creator_id'] ?? null, function (Builder $query, int $creatorId) {
            return $query->where('creator_id', '=', $creatorId);
        });
    }
}
