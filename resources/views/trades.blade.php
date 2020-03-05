@extends('layouts.app')

@section('content')
        <dashboard-panel
            market="{{ $market }}"
            :networth="{{ $networth }}"
            :stocks="{{ $stocks }}"
            :bank="{{ $bank }}"
            :user="{{ $user }}"
        ></dashboard-panel>
@endsection
