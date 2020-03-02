@extends('layouts.landing')

@section('content')
<div class="landingWrap mg-top-lg" id="landing">
    @component('loginflow')
        <h4 class="mg-btm-lg">{{ __('Login') }}</h4>
        @component('sso')
        @endcomponent
{{--        <p class="mg-btm-md mg-top-md textCenter">{{ __('Or') }}</p>--}}
{{--        <form method="POST" action="{{ route('login') }}">--}}
{{--            @csrf--}}
{{--            <label for="email" class="label label-hidden">{{ __('E-Mail Address') }}</label>--}}
{{--            <input id="email" type="email" class="mg-btm-sm input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email address') }}">--}}
{{--            @error('email')--}}
{{--                <span class="invalid-feedback" role="alert">--}}
{{--                    <strong>{{ $message }}</strong>--}}
{{--                </span>--}}
{{--            @enderror--}}

{{--            <label for="password" class="label label-hidden">{{ __('Password') }}</label>--}}
{{--            <input id="password" type="password" class="mg-btm-sm input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">--}}
{{--            @error('password')--}}
{{--                <span class="invalid-feedback" role="alert">--}}
{{--                    <strong>{{ $message }}</strong>--}}
{{--                </span>--}}
{{--            @enderror--}}


{{--            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--            <label class="label" for="remember">--}}
{{--                {{ __('Remember Me') }}--}}
{{--            </label>--}}


{{--            <button type="submit" class="button-base primary full-width mg-btm-lg">--}}
{{--                {{ __('Login') }}--}}
{{--            </button>--}}

{{--            @if (Route::has('password.request'))--}}
{{--                <a href="{{ route('password.request') }}" alt="{{ __('Forgot your password?') }}">--}}
{{--                    {{ __('Forgot your password?') }}--}}
{{--                </a>--}}
{{--            @endif--}}
{{--        </form>--}}
    @endcomponent
</div>
@endsection
