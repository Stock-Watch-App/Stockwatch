@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
    @if(Session::has('error'))
        {{Session::get('error') }}
    @endif
@endsection
