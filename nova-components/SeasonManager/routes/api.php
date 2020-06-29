<?php

use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

 Route::get('/season/current', function (Request $request) {
     return Season::current();
 });

 Route::post('/season/update/status', function (Request $request) {
     Season::current()->update(['status' => $request->all()['status']]);
 });
