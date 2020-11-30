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
     * Size of page
     * 
     * @property int
     */
    private $page_size;
    
    /**
     * Construct for Pagination trait
     */
    public function __construct()
    {
        parent::__construct();
        $this->page_size = env('PAGE_SIZE', 20);
    }

    /**
     * Pager method
     * 
     * @param int $size
     * 
     * @return \Illuminate\Pagination\Paginator
     */
    public function scopePager(Builder $query,int $size = 0)
    {
        return $query->paginate($size > 0 ? $size : $this->page_size);
    }
}