@extends('layouts.app')

@section('content')
    <profile-panel
        :user="{{ $user  }}"
        :houseguests="{{ $houseguests }}"
    >
    </profile-panel>
@endsection
