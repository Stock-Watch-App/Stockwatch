@extends('layouts.app')

@section('content')
        <h3 class="mg-btm-lg trade-heading">Buy & Sell Stocks</h3>
        <div id="market-banner" class="info flash__message">
            @if($season->status === 'open')
                <span>The market will be closing at 4pm ET @if(date('N') === '4') today @else on Thursday @endif.</span>
            @elseif($season->status === 'closed')
                <span>The market is <strong>Closed</strong>. {{--Trading will reopen following the LFC Roundtable Tuesday Evening.--}}</span>
            @endif
        </div>
        <trade-panel
            :season="{{ $season }}"
            :networth="{{ $networth }}"
            :stocks="{{ $stocks }}"
            :bank="{{ $bank }}"
            :user="{{ $user }}"
        ></trade-panel>
@endsection
