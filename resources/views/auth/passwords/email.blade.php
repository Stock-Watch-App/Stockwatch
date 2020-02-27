@extends('layouts.landing')

@section('content')
<div class="landingWrap textCenter mg-top-lg" id="landing">
    <div class="card deep">
        <h4 class="mg-btm-lg">{{ __('Reset Password') }}</h4>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

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

        <a href="/login" alt="Log in">
            <span>Go back to sign in</span>
        </a>
    </div>
</div>
@endsection
