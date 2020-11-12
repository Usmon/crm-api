<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as Console;

final class Kernel extends Console
{
    /**
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
