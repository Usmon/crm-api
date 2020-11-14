<?php

namespace App\Models\Foundation\Traits;

use Illuminate\Notifications\RoutesNotifications;

use Illuminate\Notifications\HasDatabaseNotifications;

trait Notifiable
{
    use HasDatabaseNotifications;
    use RoutesNotifications;
}
