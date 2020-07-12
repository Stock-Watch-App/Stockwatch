@extends('layouts.app')

@section('content')
    <div class="loginWrap" id="landing">
        <h3 class="mg-btm-lg text-center">{{ __('Register for an account') }}</h3>
        <a href="/login">{{ __('Or register through social') }}</a>
        <div class="loginFormWrap card">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <label for="name" class="label label-hidden">{{ __('Display Name') }}</label>
                <input id="name" type="text" class="mg-btm-sm input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Display name') }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <label for="email" class="label label-hidden">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="mg-btm-sm input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <label for="password" class="label label-hidden">{{ __('Password') }}</label>
                <input id="password" type="password" class="mg-btm-sm input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Create password') }}">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <label for="password-confirm" class="label label-hidden">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="mg-btm-sm input" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm password') }}">

                <button type="submit" class="button-base primary full-width mg-btm-lg">
                    {{ __('Sign up') }}
                </button>
            </form>
            <div class="bottom-links">
                <a href="/login" alt="Sign in">Already have an account? Sign in</a>
            </div>
        </div>
    </div>
@endsection
