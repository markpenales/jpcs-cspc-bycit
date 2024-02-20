<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class RegistrationController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::query()->updateOrCreate(
            [
                'email' => $googleUser->email,
                'google_id' => $googleUser->id
            ],
            [
                'google_id' => $googleUser->id,
                'email' => $googleUser->email,
                'name' => $googleUser->name,
                'avatar' => $googleUser->avatar,

            ]
        );

        auth()->login($user);
        return redirect()->route('home');
    }

    public function home()
    {
        return Inertia::render('Welcome', [
            'login' => route('sso.redirect'),
            'user' => auth()->user(),
        ]);
    }
}
