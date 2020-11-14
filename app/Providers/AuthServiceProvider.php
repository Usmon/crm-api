<?php

namespace App\Providers;

use App\Models\Token;

use Illuminate\Http\Request;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

final class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $policies = [
        //
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Auth::viaRequest('bearer-token', function (Request $request) {
            $bearerToken = $request->bearerToken();

            if ($bearerToken) {
                $token = Token::findByValue($bearerToken)->first();

                if ($token) {
                    $token->fill([
                        'used_at' => Carbon::now(),
                    ]);

                    $token->save();

                    return $token->user;
                }

                return null;
            }

            return null;
        });
    }
}
