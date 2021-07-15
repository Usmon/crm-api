<?php

namespace App\Models;

use App\Helpers\Json;

use App\Traits\Sort\Sorter;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Pickup
 *
 * @property int $id
 *
 * @property Carbon $pickup_datetime_start
 *
 * @property Carbon $pickup_datetime_end
 *
 * @property int $status_id
 *
 * @property int $sender_id
 *
 * @property float $price
 *
 * @property Json $type
 *
 * @property int $driver_id
 *
 * @property int $creator_id
 *
 * @property string $sender_name
 *
 * @property string $driver_name
 *
 * @property string $creator_name
 *
 * @property string $sender_phone
 *
 * @property string $creator_phone
 *
 * @property string $driver_phone
 *
 * @property string $driver_image
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @property int|null $deleted_by
 *
 * @property-read HasOne|null $sender
 *
 * @property-read HasOne|null $driver
 *
 * @property-read HasOne|null $creator
 *
 * @property-read HasMany|null $orders
 *
 * @property-read HasOne|null $status
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Pickup extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Pager;
    use Sorter;

    /**
     * @var string
     */
    protected $table = 'pickups';

    /**
     * @var array
     */
    protected $fillable = [
        'status_id',

        'sender_id',

        'price',

        'driver_id',

        'type',

        'creator_id',

        'deleted_by',
    ];

    const STATUSES = [
        'pending',

        'on_the_road',

        'at_the_office',
    ];

    /**
     * @return HasOne
     */
    public function sender(): HasOne
    {
        return $this->hasOne(Sender::class,'id','sender_id');
    }

    /**
     * @return HasOne
     */
    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class,'id','driver_id')->with(['user']);
    }

    /**
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class,'id','creator_id');
    }


    /**
     * @return HasMany
     */
    public function boxes(): HasMany
    {
        return $this->hasMany(Box::class);
    }

    /**
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(Status::class,'id','status_id');
    }

    /**
     * @return int
     */
    public function totalOrders(): int
    {
        return $this->orders->count();
    }

    /**
     * @return int
     */
    public function totalBoxes(): int
    {
        return $this->orders->sum('total_boxes');
    }

    /**
     * @return int
     */
    public function totalDeliveredBoxes(): int
    {
        return $this->orders->sum('total_delivered_boxes');
    }

    /**
     * @return int
     */
    public function totalPickedBoxes(): int
    {
        return $this->boxes->map(function (Box $box) {
            return $box->whereHas('status', function (Builder $query) {
                return $query->where('key', '=', 'At the office');
            })->count();
        })->sum();
    }

    /**
     * @return string
     */
    public function getSenderNameAttribute(): string
    {
        return $this->sender->customer->user->full_name;
    }

    /**
     * @return string
     */
    public function getDriverNameAttribute(): string
    {
        return $this->driver->user->full_name;
    }

    /**
     * @return string
     */
    public function getCreatorNameAttribute(): string
    {
        return $this->creator->full_name;
    }

    /**
     * @return array
     */
    public function getSenderPhoneAttribute(): array
    {
        return collect($this->sender->customer
            ->user()
            ->get()
            ->first()
            ->phones()
            ->latest('id')
            ->limit(3)
            ->get(['phone'])
            ->toArray())
            ->flatten()
            ->all();
    }

    /**
     * @return array
     */
    public function getCreatorPhoneAttribute(): array
    {
        return collect($this->creator->phones()->latest('id')->limit(3)->get(['phone'])->toArray())
            ->flatten()
            ->all();
    }

    /**
     * @return array
     */
    public function getDriverPhoneAttribute(): array
    {
        return collect($this->driver->user()->get()->first()->phones()->latest('id')->limit(3)->get(['phone'])
            ->toArray())
            ->flatten()
            ->all();
    }

    /**
     * @return string
     */
    public function getDriverImageAttribute()
    {
        return $this->driver['user']['profile']['photo'];
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
        })->when($filters['pickup_datetime_start'] ?? null, function (Builder $query, array $pickupDatetimeStart) {
            return $query->whereBetween('type->date->from', $pickupDatetimeStart);
        })->when($filters['pickup_datetime_end'] ?? null, function (Builder $query, array $pickupDatetimeEnd) {
            return $query->whereBetween('type->date->to', $pickupDatetimeEnd);
        })->when($filters['status'] ?? null, function (Builder $query, string $status) {
            return $query->whereHas('status', function (Builder $query) use ($status) {
                return $query->where('model', 'like', '%' . $status . '%')
                    ->orWhere('key', 'like', '%' . $status . '%')
                    ->orWhere('value', 'like', '%' . $status . '%')
                    ->orWhere('parameters', 'like', '%' . $status . '%');
            });
        })->when($filters['sender_id'] ?? null, function (Builder $query, int $senderId) {
            return $query->where('sender_id', '=', $senderId);
        })->when($filters['driver_id'] ?? null, function (Builder $query, int $driverId) {
            return $query->where('driver_id', '=', $driverId);
        })->when($filters['creator_id'] ?? null, function (Builder $query, int $creatorId) {
            return $query->where('creator_id', '=', $creatorId);
        })->when($filters['sender'] ?? null, function (Builder $query, string $driver) {
            return $query->whereHas('sender', function (Builder $query) use ($driver) {
                return $query->whereHas('customer', function (Builder $query) use ($driver) {
                    return $query->whereHas('user', function (Builder $query) use ($driver) {
                        return $query->whereHas('phones', function (Builder $query) use ($driver) {
                            return $query->where('phone', 'like', '%' . $driver . '%');
                        })->orWhere('email', 'like', '%' . $driver .'%')
                            ->orWhere('profile', 'like', '%' . $driver . '%');
                    });
                });
            });
        })->when($filters['driver'] ?? null, function (Builder $query, string $driver) {
            return $query->whereHas('driver', function (Builder $query) use ($driver) {
                return $query->whereHas('user', function (Builder $query) use ($driver) {
                    return $query->whereHas('phones', function (Builder $query) use ($driver) {
                        return $query->where('phone', 'like', '%' . $driver . '%');
                    })->orWhere('email', 'like', '%' . $driver .'%')
                        ->orWhere('profile', 'like', '%' . $driver . '%');
                });
            });
        })->when($filters['index'] ?? null, function (Builder $query, string $index) {
            return $query->where('type->index', 'like', '%' . $index . '%');
        })->when($filters['status_id'] ?? null, function (Builder $query, int $statusId) {
            return $query->where('status_id', '=', $statusId);
        });
    }
}
