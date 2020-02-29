@extends('layouts.app')

@section('content')
        <dashboard-panel
            market="{{ $market }}"
            :stocks="{{ $stocks }}"
            :bank="{{ $bank }}"
            :user="{{ $user }}"
        ></dashboard-panel>
@endsection
