<?php

use App\Http\Admin\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\DebugController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes([
    'verify' => true,
    'register' => (env('APP_ENV', 'production') === 'local') //this needs to be removed when we go live
]);
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');


Route::get('/account', function () {
    return view('account');
});

Route::get('/styleguide', function () {
    return view('styleguide');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/landing', [HomeController::class, 'landing']);

//=== LEGAL ===//
Route::get('/privacy', [LegalController::class, 'privacy']);
Route::get('/tos', [LegalController::class, 'tos']);

//=== DEBUG ===//
Route::get('/xyz', [DebugController::class, 'xyz']);
Route::get('/debug/showme/{blade}', [DebugController::class, 'showme'])->where('blade', '.*');

//===SAMPLE ROUTE===//
//Route::get('/route', function () {
//    return view('dir.file');
//});
