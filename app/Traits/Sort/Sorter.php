<?php

namespace App\Traits\Sort;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait pager for pagination collections
 *
 * @method static Builder sort(Builder $query, array $attributes)
 */
trait Sorter {
    /**
     * @param Builder $query
     *
     * @param array $attributes
     *
     * @return Builder
     */
    public function scopeSort(Builder $query, array $attributes): Builder
    {
        return $query->when($attributes['sort'] ?? null, function (Builder $query, array $attributes) {
            foreach ($attributes as $key => $value)
                $query->orderBy($key, $value);

            return $query;
        });
    }
}
