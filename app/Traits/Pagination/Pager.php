<?php

namespace App\Traits\Pagination;

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
    private static $page_size;
    
    /**
     * Construct for Pagination trait
     */
    public function __construct()
    {
        parent::__construct();
        self::$page_size = env('PAGE_SIZE', 20);
    }

    /**
     * Pager method
     * 
     * @param int $size
     * 
     * @return \Illuminate\Pagination\Paginator
     */
    public static function pager(int $size = 0)
    {
        return self::paginate($size > 0 ? $size : self::$page_size);
    }
}