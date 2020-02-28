@extends('layouts.app')

@section('content')
    <dashboard-panel
        :stocks="{{ $stocks }}"
        :bank="{{ $bank }}"
        :user="{{ $user }}"
    ></dashboard-panel>

@endsection
