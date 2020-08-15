<?php

use App\Models\File;
use App\Models\Season;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer as Csv;

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

//dd(\request());

Route::post('/generate', function (Request $request) {
    // get data
    $season = Season::current();
    $data = Transaction::with('user')->whereHas('houseguest', function ($q) use ($season) {
        $q->where('season_id', $season->id);
    })->where('week', $season->current_week)->get();

    // make file
    $csv = Csv::createFromFileObject(new \SplTempFileObject);
    $csv->insertOne(['user', 'action', 'houseguest', 'quantity', 'price']);

    $data->each(function ($transaction) use (&$csv) {
        $csv->insertOne([
            $transaction->user->hashid,
            $transaction->action,
            $transaction->houseguest->nickname,
            $transaction->quantity,
            $transaction->current_price,
        ]);
    });
    // save pointer
    $filename = date('Y-m-d') . '_' . $season->short_name . '_w' . $season->current_week . '.csv';
//    dd($csv->getContent());
    Storage::disk('stats')->put($filename, $csv->getContent());
    File::create([
        'filename'  => $filename,
        'type'      => 'stats',
        'season_id' => $season->id,
        'week'      => $season->current_week
    ]);
});

Route::get('/file/{type}/{file}', function ($type, $file) {
    return Storage::disk($type)->download($file);
});

Route::get('/files', function (Request $request) {
    return File::with('season')->get();
});
