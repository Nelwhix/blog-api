<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Receive google callback
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        User::updateOrCreate([
            'google_id' => $request->id,
        ], [
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->id),
        ])->assignRole('guest');

        return response([
            'message' => 'User logged in successfully'
        ], 200);
    }
}
