<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * Class OrderHistory
 *
 * @package App\Models
 *
 * @property integer $id
 *
 * @property integer $seq
 *
 * @property integer $order_id
 *
 * @property integer $creator_id
 *
 * @property-read User $creator
 *
 * @property Order $order
 */
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

        'status_id',

        'model',

        'creator_id'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'seq' => 'integer',

        'order_id' => 'integer',

        'model' => 'string',

        'status_id' => 'integer',

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
     * Relation to status
     *
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Relation to User (creator).
     *
     * @return HasOne
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
