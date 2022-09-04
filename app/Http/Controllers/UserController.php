<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    /**
     * Receive google callback and login user
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate([
            'google_id' => $googleUser->id,
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
        ])->assignRole('guest');


        Auth::login($user);

        return response([
            'message' => 'User logged in successfully'
        ], 200);
    }
}
