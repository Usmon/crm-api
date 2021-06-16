<?php

namespace App\Http\Controllers\User;

use App\Helpers\Json;

use App\Http\Requests\ProfileUpdate;

use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller as Controllers;
use Illuminate\Support\Facades\Hash;

final class Controller extends Controllers
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        return Json::sendJsonWith200([
            'user' => [
                'id' => $request->user()->id,

                'login' => $request->user()->login,

                'email' => $request->user()->email,

                'partner' => $request->user()->partner,

                'full_name' => $request->user()->full_name,

                'phones' => $request->user()->getPhonesWithLimit(5),

                'profile' => [
                    'first_name' => $request->user()->profile['first_name'],

                    'middle_name' => $request->user()->profile['middle_name'],

                    'last_name' => $request->user()->profile['last_name'],

                    'photo' => $request->user()->profile['photo'],
                ],

                'reports' => [
                    'counts' => [
                        'order' => $request->user()->orders->count(),

                        'delivery' => $request->user()->deliveries->count(),

                        'pickups' => $request->user()->pickups->count(),

                        'shipment' => $request->user()->shipments->count()
                    ]
                ],

                'created_at' => $request->user()->created_at,

                'updated_at' => $request->user()->updated_at,
            ],
        ]);
    }


    public function update(ProfileUpdate $request)
    {

        $credentials = $request->validated();

        $credentials['password'] = Hash::make($credentials['password']);

        $credentials['profile'] = [
            'first_name' => null,

            'last_name' => null,

            'middle_name' => null,

            'photo' => $credentials['photo']
        ];

        $user = $request->user();

        $user->fill($credentials)->update();

        Phone::where('user_id', $user->id)->delete();

        foreach ($credentials['phones'] as $phone) {
            Phone::create([
                'user_id' => $user->id,

                'phone' => $phone
            ]);
        }

        return $this->__invoke($request);
    }
}
