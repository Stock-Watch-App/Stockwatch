@extends('layouts.app')

@section('content')
        <trade-panel
            :season="{{ $season }}"
            :networth="{{ $networth }}"
            :stocks="{{ $stocks }}"
            :bank="{{ $bank }}"
            :user="{{ $user }}"
        ></trade-panel>
@endsection
