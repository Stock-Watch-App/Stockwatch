@extends('layouts.app')

@section('content')
    <div class="leaderboard-wrap">
        <h3 class="mg-btm-lg alltime-leader-title">All-Time Leaderboard</h3>
            <all-leaderboard-table
                :leaderboard="{{ $leaderboard }}"
            ></all-leaderboard-table>
    </div>
@endsection
