<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class SSOController extends Controller
{
    public function handle(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect('/login')->withErrors(['Token missing']);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return redirect('/login')->withErrors(['Invalid token']);
        }

        $user = $accessToken->tokenable;

        if (!$user) {
            return redirect('/login')->withErrors(['User not found']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

}
