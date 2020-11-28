<?php

namespace App\Models;

use App\Models\Pickup;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Order extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $casts = [];



    /**
     * @return BelongsTo
     */
    public function pickups(): BelongsTo
    {
        return $this->belongsTo(Pickup::class);
    }
}
