@extends('layouts.app')

@section('content')
    <profile-panel
        :user="{{ $user  }}"
        :houseguests="{{ $houseguests }}"
        :week="{{ $season->current_week }}"
    >
    </profile-panel>
@endsection
