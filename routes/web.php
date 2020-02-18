<?php

use App\Http\Controllers\LegalController;
use App\Http\Controllers\DebugController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/landing', function () {
    return view('landing');
});

Route::get('/privacy', [LegalController::class, 'privacy']);
Route::get('/tos', [LegalController::class, 'tos']);


Route::get('/debug/showme/{blade}', [DebugController::class, 'showme'])->where('route', '.*');
//===SAMPLE ROUTE===//
//Route::get('/route', function () {
//    return view('dir.file');
//});
