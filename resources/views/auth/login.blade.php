@extends('layouts.landing')

@section('content')
<div class="landingWrap textCenter mg-top-lg" id="landing">
    <div class="card deep">
        <h2 class="mg-btm-lg">{{ __('Login') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email" class="label label-hidden">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="mg-btm-sm text-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email address') }}">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="password" class="label label-hidden">{{ __('Password') }}</label>
            <input id="password" type="password" class="mg-btm-sm text-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror


            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="label" for="remember">
                {{ __('Remember Me') }}
            </label>


            <button type="submit" class="button-base primary full-width mg-btm-lg">
                {{ __('Login') }}
            </button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" alt="{{ __('Forgot your password?') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <p class="mg-btm-md mg-top-md">{{ __('Or') }}</p>
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
            <a class="button-base twitch icon" href="/login/twitch" alt="Sign in with Twich">
                <figure>
                    <font-awesome-icon :icon="['fab', 'twitch']" size="lg"/>
                </figure>
                <span>Sign-in with Twitch</span>
            </a>
        </form>
    </div>
</div>
@endsection
