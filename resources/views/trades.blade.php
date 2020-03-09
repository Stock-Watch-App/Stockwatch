@extends('layouts.app')

@section('content')
        <h3 class="mg-btm-lg trade-heading">Buy & Sell Stocks</h3>
        <trade-panel
            :season="{{ $season }}"
            :networth="{{ $networth }}"
            :stocks="{{ $stocks }}"
            :bank="{{ $bank }}"
            :user="{{ $user }}"
        ></trade-panel>
@endsection
