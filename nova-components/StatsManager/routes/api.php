<?php

use App\Models\File;
use App\Models\Season;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    ini_set('memory_limit', '256M');

    // get data
    $week = $request->get('week');
    $season = Season::current();
    $data = Transaction::whereHas('user')->whereHas('houseguest', function ($q) use ($season) {
        $q->withoutGlobalScope('active');
        $q->where('season_id', $season->id);
    })->with([
        'houseguest' => function ($q) use ($season) {
            $q->withoutGlobalScope('active');
        }
    ])->where('week', $week)->get();

    // make file
    $csv = Csv::createFromFileObject(new \SplTempFileObject);
    $csv->insertOne(['user', 'username', 'action', 'houseguest', 'quantity', 'price']);

    $data->each(function ($transaction) use (&$csv) {
        $csv->insertOne([
            $transaction->user->hashid,
            $transaction->user->name,
            $transaction->action,
            $transaction->houseguest->nickname,
            $transaction->quantity,
            $transaction->current_price,
        ]);

    });
    // save pointer
    $filename = date('Y-m-d') . '_' . $season->short_name . '_w' . $week . '.csv';
    Storage::disk('stats')->put($filename, $csv->getContent());
    File::create([
        'filename'  => $filename,
        'type'      => 'stats',
        'season_id' => $season->id,
        'week'      => $week
    ]);
});

Route::get('/file/{type}/{file}', function ($type, $file) {
    return Storage::disk($type)->download($file);
});

Route::get('/files', function (Request $request) {
    return File::with('season')->orderByDesc('week')->get();
});

Route::get('/stats/total/stocks', function () {
    /* select h.nickname, sum(s.quantity) as total
     * from stocks s
     * join houseguests h on s.houseguest_id = h.id
     * where houseguest_id > 16
     * group by h.nickname
     * order by total desc;
     */
    $season = Season::current();
    return DB::table('stocks')
             ->select(DB::raw('houseguests.nickname, sum(stocks.quantity) as total'))
             ->join('houseguests', 'stocks.houseguest_id', '=', 'houseguests.id')
             ->whereRaw('houseguests.season_id = ?', $season->id)
             ->groupBy('houseguests.nickname')
             ->orderByDesc('total')
             ->get();

});
Route::get('/stats/total/money', function () {
    /* select h.nickname, sum(s.quantity*p.price) as total
     * from stocks s
     * join houseguests h on s.houseguest_id = h.id
     * join prices p on s.houseguest_id = p.houseguest_id
     * where s.houseguest_id > 16
     * and p.week = 1
     * group by h.nickname
     * order by total desc;
     */
    $season = Season::current();
    return DB::table('stocks')
             ->select(DB::raw('houseguests.nickname, sum(stocks.quantity*prices.price) as total'))
             ->join('houseguests', 'stocks.houseguest_id', '=', 'houseguests.id')
             ->join('prices', 'stocks.houseguest_id', '=', 'prices.houseguest_id')
             ->whereRaw('houseguests.season_id = ?', $season->id)
             ->whereRaw('prices.week = ?', ($season->status === 'closed') ? $season->current_week : $season->current_week - 1)
             ->groupBy('houseguests.nickname')
             ->orderByDesc('total')
             ->get();

});
