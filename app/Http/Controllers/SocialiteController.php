<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleLoginCallback()
    {
        $userData = Socialite::driver('google')->user();

        $user = User::where('email', $userData->email)->first();

        if (!$user) {
            $user = User::create([
                'name'   => $userData->name,
                'email'  => $userData->email,
                'avatar' => $userData->avatar
            ]);
        }

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
