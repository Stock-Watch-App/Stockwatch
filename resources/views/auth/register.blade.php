@extends('layouts.landing')

@section('content')
<div class="landingWrap textCenter mg-top-lg" id="landing">
    <h1>We need a copy writer</h1>
    <div class="card deep">
        <h2 class="mg-btm-lg">Sign up to join in on this season's Stock Watch</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label for="name" class="label label-hidden">{{ __('Name') }}</label>
            <input id="name" type="text" class="mg-btm-sm text-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Full name') }}">
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="email" class="label label-hidden">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="mg-btm-sm text-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="password" class="label label-hidden">{{ __('Password') }}</label>
            <input id="password" type="password" class="mg-btm-sm text-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Create password') }}">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="password-confirm" class="label label-hidden">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="mg-btm-sm text-input" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm password') }}">

            <button type="submit" class="button-base primary full-width mg-btm-lg">
                {{ __('Sign up') }}
            </button>
        </form>
        <p class="mg-btm-lg">{{ __('Or') }}</p>
        <a class="button-base twitter icon mg-btm-sm" href="/login/twitter" alt="Sign in with Twitter">
            <figure>
                <font-awesome-icon :icon="['fab', 'twitter']" size="lg"/>
            </figure>
            <span>Sign-in with Twitter</span>
        </a>
        <a class="button-base facebook icon mg-btm-sm" href="/login/facebook" alt="Sign in with Facebook">
            <figure>
                <font-awesome-icon :icon="['fab', 'facebook']" size="lg"/>
            </figure>
            <span>Sign-in with Facebook</span>
        </a>
        <a class="button-base discord icon mg-btm-sm" href="/login/discord" alt="Sign in with Discord">
            <figure>
                <font-awesome-icon :icon="['fab', 'discord']" size="lg"/>
            </figure>
            <span>Sign-in with Discord</span>
        </a>
        <a class="button-base twitch icon mg-btm-lg" href="/login/twitch" alt="Sign in with Twich">
            <figure>
                <font-awesome-icon :icon="['fab', 'twitch']" size="lg"/>
            </figure>
            <span>Sign-in with Twitch</span>
        </a>

        <a href="/login" alt="Log in">
            <span>Already have an account? Sign in</span>
        </a>
    </div>
</div>
@endsection
