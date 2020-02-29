@extends('layouts.landing')

@section('content')
<div class="landingWrap textCenter mg-top-lg" id="landing">
    @component('loginflow')
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
                <a href="/landing" alt="Sign up with social media">Or register with social</a>
                <a href="/login" alt="Sign in">Sign in</a>
            </div>
    @endcomponent
</div>
@endsection
