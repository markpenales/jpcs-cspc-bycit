<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QRCodeController;
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
Route::get('/register', [RegistrationController::class, 'register'])->name('register')->middleware('auth');
Route::get('/', [RegistrationController::class, 'home'])->name('home');


Route::middleware(['guest'])->prefix('/callback')->as('sso.')->group(function () {
    Route::get('/redirect', [RegistrationController::class, 'redirect'])
        ->name('redirect');
    Route::get('/google', [RegistrationController::class, 'callback'])
        ->name('callback');

});

Route::middleware(['auth'])->post('/logout', function () {
    auth()->logout();
    session()->flush();
    return redirect('/');
});


Route::middleware(['is-admin'])->prefix('/scanner')->as('scan.')->group(function () {
    Route::get('/', [QRCodeController::class, 'index'])->name('scan');
    Route::get('/villafuerte_hall', [QRCodeController::class, 'villafuerteHall'])->name('villafuerte_hall');
    Route::get('/pearl', [QRCodeController::class, 'pearl'])->name('pearl');
    Route::get('/ctde', [QRCodeController::class, 'ctde'])->name('ctde');
    Route::get('/auditorium', [QRCodeController::class, 'auditorium'])->name('auditorium');

    Route::get('/scan', [QRCodeController::class, 'save'])->name('save');

});

Route::get('/{register}', [QRCodeController::class, 'scan'])->middleware('redirect-con-guide');

require __DIR__ . '/auth.php';
