<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [RegistrationController::class, 'home'])->name('home');

Route::middleware(['guest'])->prefix('/callback')->as('sso.')->group(function () {

    Route::get('/redirect', [RegistrationController::class, 'redirect'])
        ->name('redirect');
    Route::get('/google', [RegistrationController::class, 'callback'])
        ->name('callback');
});


require __DIR__ . '/auth.php';
