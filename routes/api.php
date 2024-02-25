<?php

use App\Models\Section;
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
        'college' => ["required", "exists:colleges,name"],
        'nickname' => $stringRule,
        'program' => ['nullable', 'exists:programs,id'],
        'year' => ['nullable', 'exists:years,id'],
        'section' => ['nullable', 'exists:sections,id'],
        'tshirt' => ['exists:t_shirt_sizes,id'],
        'dietaryRestrictions' => $stringRule,
    ]);

    dd("Attributes", [
        $attributes['lastName'],
        $attributes['firstName'],
        $attributes['middleInitial'],
        $attributes['suffix'],
        $attributes['college'],
        $attributes['nickname'],
        $attributes['program'],
        $attributes['year'],
        $attributes['section'],
        $attributes['tshirt'],
        $attributes['dietaryRestrictions'],
    ]);
});