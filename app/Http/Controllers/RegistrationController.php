<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Program;
use App\Models\Section;
use App\Models\Suffix;
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

        $user = User::query()->firstOrCreate(
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
        return redirect()->route('register');
    }

    public function home()
    {
        if (auth()->user()) {
            return redirect()->route('register');
        }
        $assets = [
            'mascot' => asset('/assets/mascot.png'),
            'circle' => asset('assets/Circle.svg'),
            'bycit_logo' => asset('assets/logo.png'),
            'background' => asset('assets/background.svg')
        ];
        return Inertia::render('Welcome', [
            'login' => route('sso.redirect'),
            'assets' => $assets,
        ]);
    }

    public function register(Request $request)
    {
        $assets = [
            'mascot' => asset('/assets/mascot.png'),
            'circle' => asset('assets/Circle.svg'),
            'bycit_logo' => asset('assets/logo.png'),
            'background' => asset('assets/background.svg'),
            'shirt_guide' => asset('assets/shirt1.png'),
        ];

        return Inertia::render('Register', [
            'user' => auth()->user()->load('section'),
            'colleges' => College::query()->orderBy('name', 'asc')->get(),
            'programs' => Program::query()->orderBy('name', 'asc')->get(),
            'years' => Year::query()->orderBy('name', 'asc')->get(),
            'sections' => Section::all(),
            'sizes' => TShirtSize::all(),
            'suffixes' => Suffix::all(),
            'assets' => $assets,
        ]);
    }
}
