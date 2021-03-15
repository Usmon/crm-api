<?php

namespace App\Http\Controllers\Commands;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Artisan;

/**
 * Class ArtisanController
 *
 * @package App\Http\Controllers\Commands
 */
class ArtisanController extends Controller
{
    /**
     * @return mixed
     */
    public function migrateSeed()
    {
        return Artisan::call('migrate:fresh --seed');
    }
}
