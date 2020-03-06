@extends('layouts.app')

@section('content')
        <trade-panel
            market="{{ $market }}"
            :networth="{{ $networth }}"
            :stocks="{{ $stocks }}"
            :bank="{{ $bank }}"
            :user="{{ $user }}"
        ></trade-panel>
@endsection
