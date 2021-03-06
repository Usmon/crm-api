<?php

namespace App\Models\Foundation;

use App\Models\Foundation\Traits\Notifiable;

use App\Models\Foundation\Traits\ResetToken;

use App\Models\Foundation\Traits\VerifyToken;

use App\Models\Foundation\Traits\Authorizable;

use App\Models\Foundation\Traits\Authenticatable;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Illuminate\Database\Eloquent\Model;

abstract class Auth extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use Notifiable;
    use ResetToken;
    use VerifyToken;
}
