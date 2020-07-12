@extends('layouts.app')

@section('content')
<div class="loginWrap" id="landing">
    <div class="loginFormWrap card">
        <h4 class="mg-btm-lg">{{ __('Verify your email address') }}</h4>

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <p>{{ __('Before proceeding, please check your email for a verification link. Make sure to check your spam folder.') }}</p>
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="button-base primary full-width mg-btm-lg">{{ __('Click here to request another') }}</button>
        </form>
    </div>
</div>
@endsection
