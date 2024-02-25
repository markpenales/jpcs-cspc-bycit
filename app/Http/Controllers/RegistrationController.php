<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Program;
use App\Models\Section;
use App\Models\TShirtSize;
use App\Models\User;
use App\Models\Year;
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
                'last_name' => $googleUser->user['family_name'] ?? '',
                'first_name' => $googleUser->user['given_name'] ?? '',

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
            'colleges' => College::query()->orderBy('name', 'asc')->get(),
            'programs' => Program::query()->orderBy('name', 'asc')->get(),
            'years' => Year::query()->orderBy('name', 'asc')->get(),
            'sections' => Section::all(),
            'sizes' => TShirtSize::all(),
        ]);
    }
}
