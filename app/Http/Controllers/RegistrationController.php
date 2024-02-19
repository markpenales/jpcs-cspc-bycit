<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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

        return redirect()->intended();
    }
}
