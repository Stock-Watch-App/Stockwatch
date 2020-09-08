@extends('layouts.app')

@section('content')
    <div class="leaderboard-wrap">
        <h3 class="mg-btm-lg">{{ $season->name }} Leaderboard</h3>
            <leaderboard-table
                :houseguests="{{ $houseguests }}"
                :leaderboard="{{ json_encode($leaderboard->toArray()['data']) }}"
                search="{{ request()->get('search') }}"
            ></leaderboard-table>
    </div>

    {{ $leaderboard->appends(['search' => request()->get('search')])->links() }}
@endsection
