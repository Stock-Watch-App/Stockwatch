@extends('layouts.app')

@section('content')
    <div class="user-details">
        <funds></funds>
    </div>
    <div class="stock-cards-wrap">
        <dashboard-panel
            market="{{ $market }}"
            :stocks="{{ $stocks }}"
            :bank="{{ $bank }}"
            :user="{{ $user }}"
        ></dashboard-panel>
    </div>
@endsection
