<?php

namespace App\Traits;

use App\UserLogin;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;


trait LogoutFromOtherDevice
{
    public function logoutFromOtherDevice($user)
    {
        if ($user->tokens()->count() > 0) {
            $currentAccessToken = $user->tokens()->latest()->first()->id;

            Token::where('user_id', $user->id)
                ->where('id', '!=', $currentAccessToken)
                ->update(['revoked' => true]);
        }


        $query2 = UserLogin::where([
            'user_id' => $user->id,
        ]);

        if (session('login_token')) {
            $query2->whereNot([
                'token' => session('login_token'),
            ]);
        }
        $query2->update([
            'status' => 0
        ]);
    }

    public function logoutFromCurrentDevice($user)
    {

        if ($user->tokens()->count() > 0) {
            $currentAccessToken = $user->tokens()->latest()->first()->id;
            Token::where('user_id', $user->id)
                ->where('id', $currentAccessToken)
                ->update(['revoked' => true]);
        }

        $query2 = UserLogin::where([
            'user_id' => $user->id,
        ]);

        if (session('login_token')) {
            $query2->where([
                'token' => session('login_token'),
            ]);
        }
        $query2->update([
            'status' => 0
        ]);

        Auth::guard('web')->logout();


    }
}
