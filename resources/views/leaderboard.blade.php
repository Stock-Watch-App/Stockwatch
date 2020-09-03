@extends('layouts.app')

@section('content')
    <div class="leaderboard-wrap">
        <h3 class="mg-btm-lg">{{ $season->name }} Leaderboard</h3>
            <leaderboard-table
                :houseguests="{{ $houseguests }}"
                :leaderboards="{{ json_encode($leaderboard->toArray()['data']) }}"
            ></leaderboard-table>
    </div>
    {{ $leaderboard->links() }}
@endsection

