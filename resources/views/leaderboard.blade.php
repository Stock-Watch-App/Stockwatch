@extends('layouts.app')

@section('content')
    <div class="leaderboard-wrap">
        <h3 class="mg-btm-lg">Leaderboard</h3>
            <leaderboard-table
                :houseguest="{{ $houseguests }}"
            ></leaderboard-table>
    </div>
@endsection
