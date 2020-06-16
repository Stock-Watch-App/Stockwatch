@extends('layouts.app')

@section('content')
    <div class="leaderboard-wrap">
        <h3 class="mg-btm-lg">{{ $season->name }} Leaderboard</h3>
            <!-- <div class="perfect-play">
                <p class="heading">Perfect Play</p>
                <div class="hg-img">
                    <img src="{{ asset('/storage/avatar-default.svg') }}" alt="">
                </div>
                <div class="hg-details">
                    <p>Carol</p>
                    <p>$4,000</p>
                </div>
            </div> -->
            <leaderboard-table
                :houseguests="{{ $houseguests }}"
                :leaderboard="{{ $leaderboard }}"
            ></leaderboard-table>
    </div>
@endsection
