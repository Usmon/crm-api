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

        $this->registerBearerToken();
    }

    /**
     * @return void
     */
    protected function registerBearerToken(): void
    {
        Auth::viaRequest('bearer-token', function (Request $request) {
            if (! $request->bearerToken()) {
                return null;
            }

            $token = Token::findBy('value', $request->bearerToken())->first();

            if (! $token) {
                return null;
            }

            $token->fill([
                'device' => [
                    'ip' => $request->ip(),

                    'os' => $token->device['os'],

                    'type' => $token->device['type'],

                    'name' => $token->device['name'],
                ],

                'used_at' => Carbon::now(),
            ]);

            $token->save();

            return $token->user;
        });
    }
}
