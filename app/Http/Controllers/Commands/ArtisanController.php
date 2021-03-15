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
     * @return void
     */
    public function migrateSeed(): void
    {
        Artisan::call('migrate:fresh --seed');
    }
}
