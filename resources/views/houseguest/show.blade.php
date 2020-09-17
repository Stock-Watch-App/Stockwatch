@extends('layouts.app')

@section('content')
    <div class="leaderboard-wrap">
        <h3 class="mg-btm-lg">{{ $houseguest->nickname }}</h3>

        {{ $houseguest }}
    </div>
@endsection
