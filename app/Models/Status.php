<?php

namespace App\Models;

use App\Traits\Sort\Sorter;

use Illuminate\Support\Carbon;

use App\Traits\Pagination\Pager;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Status
 *
 * @property integer $id
 *
 * @property string $model
 *
 * @property string $key
 *
 * @property string $value
 *
 * @property string $parameters
 *
 * @property-read array $for_color
 *
 * @property Carbon|null $created_at
 *
 * @property Carbon|null $updated_at
 *
 * @property Carbon|null $deleted_at
 *
 * @method static Builder|self findBy(string $key, string $value = null)
 *
 * @method static Builder|self filter(array $filters)
 *
 * @mixin Model
 */
final class Status extends Model
{
    use Pager;
    use Sorter;
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'statuses';

    /**
     * @var array
     */
    protected $fillable = [
        'model',

        'key',

        'value',

        'parameters',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'model' => 'string',

        'key' => 'string',

        'value' => 'string',

        'parameters' => 'array',

        'created_at' => 'datetime',

        'updated_at' => 'datetime',

        'deleted_at' => 'datetime',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'model',

        'created_at',

        'updated_at',

        'deleted_at'
    ];

    public function getForColorAttribute(): array
    {
        return [
            'id' => $this->id,

            'name' => $this->value,

            'color' => [
                'bg' => $this->parameters['color']['bg'],

                'text' => $this->parameters['color']['text'],
            ],
        ];
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
                return $query->where('model', 'like', '%' . $search . '%')
                    ->orWhere('key', 'like', '%' . $search . '%')
                    ->orWhere('value', 'like', '%' . $search . '%')
                    ->orWhere('parameters', 'like', '%' . $search . '%');
            });
        })->when($filters['date'] ?? null, function (Builder $query, array $date) {
            return $query->whereBetween('created_at', $date);
        })->when($filters['model'] ?? null, function (Builder $query, string $model) {
            return $query->where('model','like','%'. $model .'%');
        })->when($filters['key'] ?? null, function (Builder $query, string $key) {
            return $query->where('key', 'like', '%' . $key . '%');
        })->when($filters['value'] ?? null, function (Builder $query, string $value) {
            return $query->where('value', 'like', '%' . $value . '%');
        })->when($filters['parameters'] ?? null, function (Builder $query, string $parameters) {
            return $query->where('parameters', 'like', '%' . $parameters . '%');
        });
    }

    /**
     * @param Builder $query
     *
     * @param array $filters
     *
     * @return Builder
     */
    public function scopeByModel(Builder $query, string $model_name): Builder
    {
        return $query->where('model', $model_name);
    }
}
