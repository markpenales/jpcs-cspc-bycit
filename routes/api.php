<?php

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
        'dietaryRestrictions' => ['nullable', 'max:255', 'min:3'],
        'user' => 'required'
    ]);


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
    $dietaryRestrictions = Str::of($attributes['dietaryRestrictions'])->trim()->replaceMatches('/\s+/', ' ')->ucfirst()->toString();

    $user = User::find($attributes['user']);

    $user->last_name = !empty($lastName) ? $lastName : null;
    $user->first_name = !empty($firstName) ? $firstName : null;
    $user->middle_initial = !empty($middleInitial) ? $middleInitial : null;
    $user->suffix = !empty($suffix) ? $suffix : null;

    $user->college_id = !empty($college) ? $college : null;
    $user->nickname = !empty($nickname) ? $nickname : null;
    $user->section_id = !empty($section) ? $section : null;
    $user->t_shirt_size_id = !empty($tshirt) ? $tshirt : null;
    $user->dietary_restrictions = !empty($dietaryRestrictions) ? $dietaryRestrictions : null;


    $user->save();

    return response()->json(["data" => ["message" => "User Updated Successfully"]]);
});