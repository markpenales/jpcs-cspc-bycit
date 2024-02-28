<?php

use App\Models\DietaryRestriction;
use App\Models\Registration;
use App\Models\Restriction;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', function (Request $request) {
    $stringRule = ['required', 'max:255', 'min:3'];
    $attributes = $request->validate([
        'lastName' => $stringRule,
        'firstName' => $stringRule,
        'middleInitial' => ['nullable', 'max:4'],
        'suffix' => ['nullable', 'exists:suffixes,id'],
        'college' => ["required", "exists:colleges,id"],
        'nickname' => $stringRule,
        'program' => ['nullable', 'exists:programs,id'],
        'year' => ['nullable', 'exists:years,id'],
        'section' => ['nullable', 'exists:sections,id'],
        'tshirt' => ['exists:t_shirt_sizes,id'],
        'user' => 'required',
        'confirm' => 'accepted',
        'restrictions.3.allergy' => ['required_if:restrictions.3.checked,true', 'max:255', 'min:3'],
    ]);

    // Check if the college value is equal to 1
    if ($attributes['college'] == 1) {
        // Add additional validation rules for program, year, and section
        $additionalRules = [
            'program' => 'required|exists:programs,id',
            'year' => 'required|exists:years,id',
            'section' => 'required|exists:sections,id',
        ];

        // Merge additional rules with the existing rules
        $attributes = array_merge($attributes, $request->validate($additionalRules));
    }


    $lastName = Str::of($attributes['lastName'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();
    $firstName = Str::of($attributes['firstName'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();
    $middleInitial = Str::of($attributes['middleInitial'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();
    $suffix = Str::of($attributes['suffix'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();
    $college = Str::of($attributes['college'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();
    $nickname = Str::of($attributes['nickname'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();
    $program = Str::of($attributes['program'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();
    $year = Str::of($attributes['year'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();
    $section = Str::of($attributes['section'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();
    $tshirt = Str::of($attributes['tshirt'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();

    $user = User::find($attributes['user']);

    $user->last_name = !empty($lastName) ? $lastName : null;
    $user->first_name = !empty($firstName) ? $firstName : null;
    $user->middle_initial = !empty($middleInitial) ? $middleInitial : null;
    $user->suffix = !empty($suffix) ? $suffix : null;

    $user->college_id = !empty($college) ? $college : null;
    $user->nickname = !empty($nickname) ? $nickname : null;
    $user->section_id = !empty($section) ? $section : null;
    $user->t_shirt_size_id = !empty($tshirt) ? $tshirt : null;


    $user->save();

    $dietaryRestrictions = $request->restrictions;

    $dietaryRestrictionsCollection = collect($dietaryRestrictions); // Convert to collection

    $dietaryRestrictionsCollection->each(function ($restriction) use ($user) {
        if (isset($restriction['checked'])) {

            $user->restrictions()->firstOrCreate([
                'restriction_id' => Restriction::query()->where('name', $restriction['name'])->first()->id,
                'allergies' => $restriction['allergy'] ?? '',
            ]);
        }
    });

    Registration::query()->firstOrCreate([
        'user_id' => $user->id,

    ]);

    return response()->json(["data" => ["message" => "Registered Successfully!"]]);
})->middleware('throttle:6,1');
