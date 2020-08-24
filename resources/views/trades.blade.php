@extends('layouts.app')

@section('content')
    @if(Auth::check() && Auth::user()->hasVerifiedEmail() && Auth::user()->isPlaying())
        <h3 class="mg-btm-lg trade-heading">Buy & Sell Stocks</h3>
        <div id="market-banner" class="info flash__message">
            @if($season->status === 'open')
                <span>The market will be closing at 8pm ET @if(((new DateTime())->setTimezone(new DateTimeZone('America/New_York'))->format('N')) === '4') today @else on Thursday @endif.</span>
            @elseif($season->status === 'closed')
                <span>The market is <strong>Closed</strong>. Trading will reopen following the LFC Roundtable Tuesday Evening.</span>
            @endif
        </div>
        <trade-panel
            :season="{{ $season }}"
            :networth="{{ $networth ?? null  }}"
            :stocks="{{ $stocks }}"
            :bank="{{ $bank ?? null }}"
            :user="{{ $user ?? null }}"
        ></trade-panel>
    @else
        <h3 class="mg-btm-lg trade-heading">{{ $season->name }} Stocks</h3>
        @if($stateOfUser === 'spectator')
            <a href="{{ route('join.game') }}"><button class="button-base secondary mg-btm-sm">Join the Game!</button></a>
        @endif
        <guest-trade-panel
            :season="{{ $season }}"
            :stocks="{{ $stocks }}"
        ></guest-trade-panel>
    @endif
@endsection
