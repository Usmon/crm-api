<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\HasOne;

final class OrderHistory extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'order_histories';

    /**
     * @var array
     */
    protected $fillable = [
        'seq',

        'order_id',

        'creator_id'
    ];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $casts = [
        'seq' => 'integer',

        'order_id' => 'integer',

        'creator_id' => 'integer'
    ];

    /**
     * Relation to order.
     *
     * @return HasOne
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    /**
     * Relation to User (creator).
     *
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
