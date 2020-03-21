@extends('layouts.app')

@section('content')
    <dashboard-panel
        :user="{{ $user  }}"
        :houseguests="{{ $houseguests }}"
    >
    </dashboard-panel>
@endsection
