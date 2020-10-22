<?php

use App\Models\Houseguest;
use App\Models\Season;
use App\Models\VanityTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stockwatch\SeasonManager\Http\Controllers\ApiController;

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

Route::get('/season/current', [ApiController::class, 'getCurrentSeason']);

Route::post('/season/update/status', [ApiController::class, 'getSeasonStatus']);

Route::post('/save/tags', [ApiController::class, 'saveTags']);

Route::post('/save/rating/{rating}/week/{week}/houseguest/{houseguest}/lfc/{lfc}', [ApiController::class, 'saveRating']);

Route::get('/houseguests', [ApiController::class, 'getHouseguests']);
Route::get('/lfc', [ApiController::class, 'getLfc']);

Route::get('/week/{week}', [ApiController::class, 'getWeeklyData']);

Route::post('/evict/{nickname}', [ApiController::class, 'evict']);

Route::post('/unevict/{nickname}', [ApiController::class, 'unevict']);
