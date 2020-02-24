<?php

use App\Http\Admin\Controllers\UserController;
use App\Http\Controllers\HomeController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/landing', [HomeController::class, 'landing']);
Route::get('/privacy', [LegalController::class, 'privacy']);
Route::get('/tos', [LegalController::class, 'tos']);

Route::post('/admin/season/create');

Route::get('/user', [UserController::class, 'index'])->middleware('role:admin|user moderator')->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->middleware('permission:create user')->name('user.create');
Route::post('/user', [UserController::class, 'store'])->middleware('permission:create user')->name('user.store');
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->middleware('permission:edit user')->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->middleware('permission:edit user')->name('user.update');
Route::put('/user/ban/{id}', [UserController::class, 'ban'])->middleware('permission:ban user')->name('user.ban');
Route::put('/user/unban/{id}', [UserController::class, 'unban'])->middleware('permission:ban user')->name('user.unban');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->middleware('permission:delete user')->name('user.destroy');

//=== DEBUG ===//
Route::get('/xyz', [DebugController::class, 'xyz']);
Route::get('/debug/showme/{blade}', [DebugController::class, 'showme'])->where('blade', '.*');

//===SAMPLE ROUTE===//
//Route::get('/route', function () {
//    return view('dir.file');
//});
