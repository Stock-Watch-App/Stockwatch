@extends('layouts.app')

@section('content')
<div class="loginWrap" id="landing">
    <h3 class="mg-btm-sm text-center">{{ __('Reset Password') }}</h3>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="loginFormWrap card">

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label for="email" class="label label-hidden">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="mg-btm-sm input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email address') }}">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <button type="submit" class="button-base primary full-width mg-btm-lg">
                {{ __('Send Password Reset Link') }}
            </button>
        </form>
        <div class="bottom-links">
            <a href="/login" alt="Sign in">Go back to sign-in</a>
        </div>
    </div>
</div>
@endsection
