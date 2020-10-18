<?php

use App\Http\Admin\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectionController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HouseguestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify'   => true]);
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

//=== LEGAL ===//
Route::get('/privacy', [LegalController::class, 'privacy']);
Route::get('/tos', [LegalController::class, 'tos']);

Route::get('/landing', [HomeController::class, 'landing']);

Route::get('/projections', [ProjectionController::class, 'index']);

Route::get('/trades', [TradeController::class, 'index'])->name('trade');

Route::get('/houseguest/{season}/{houseguest}', [HouseguestController::class, 'show'])->name('houseguest.show');

Route::get('/leaderboard', [LeaderboardController::class, 'allTime'])->name('allTimeLeaderboard');
//    Route::get('/leaderboard/bbus', [LeaderboardController::class, 'allTime'])->name('bbusLeaderboard');
//    Route::get('/leaderboard/bbcan', [LeaderboardController::class, 'allTime'])->name('bbcanLeaderboard');
Route::get('/leaderboard/{season}', [LeaderboardController::class, 'index'])->name('leaderboard');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect()->route('trade');
    });

    Route::get('/account', [UserController::class, 'account'])->name('account.edit');
    Route::post('/account/update', [UserController::class, 'update'])->name('account.update');
    Route::post('/account/avatar/use/{type}', [UserController::class, 'useAvatar'])->name('avatar.use');
    Route::post('/account/avatar/upload', [ImageController::class, 'uploadAvatar'])->name('avatar.upload');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/trades/join', [TradeController::class, 'initGame'])->name('join.game');
    Route::post('/trades/savestocks', [TradeController::class, 'savestocks']);
});

Route::get('/faq', [FaqController::class, 'show'])->name('faq');

Route::get('/maintenance', function () {
    return view('maintenance');
});


Route::group(['middleware' => ['local']], function () {
    Route::get('/styleguide', function () {
        return view('styleguide');
    });

    //=== DEBUG ===//
    Route::get('/xyz', [DebugController::class, 'xyz']);
    Route::get('/leaderboard/calculate', [LeaderboardController::class, 'calculate']);
    Route::get('/debug/showme/{blade}', [DebugController::class, 'showme'])->where('blade', '.*');

    Route::get('users/{user}', function (App\Models\User $user) {
        dump($user);
    });
    Route::get('users', function () {
        $u = App\Models\User::limit(10)->get();
        foreach ($u as $m) {
            dump($m->hashid);
        }
    });
    Route::get('/test/error/{error}', function ($error) {
        abort($error);
    });
});

Route::get('/profile/{user}', [ProfileController::class, 'index'])->name('profile');

// Route::get('/roundtable', [RoundtableController::class, 'index'])->name('roundtable');

Route::get('/roundtable', function () {
    return view('roundtable');
});


//===


//===SAMPLE ROUTE===//
//Route::get('/route', function () {
//    return view('dir.file');
//});
