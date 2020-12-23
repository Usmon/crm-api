<?php

namespace App\Traits\Pagination;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait pager for pagination collections
 * 
 * @method static Illuminate\Pagination\Paginator pager(int $size)
 */
trait Pager
{
    /**
     * Pager method
     * 
     * @param int $size
     * 
     * @return \Illuminate\Pagination\Paginator
     */
    public function scopePager(Builder $query,int $size = 0)
    {
        return $query->paginate(request()->get('page_size') ?? $size ?? config('app.page_size'));
    }
}