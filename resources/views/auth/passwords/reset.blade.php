@extends('layouts.landing')

<!-- not sure this blade is in use -->

@section('content')
<div class="landingWrap textCenter mg-top-lg" id="landing">
    <div class="card deep">
       <h2 class="mg-btm-lg">{{ __('Reset Password') }}</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email" class="label label-hidden">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="mg-btm-sm text-input @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email address') }}">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="password" class="label label-hidden">{{ __('Password') }}</label>
            <input id="password" type="password" class="mg-btm-sm text-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('New password') }}">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="password-confirm" class="label label-hidden">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" class="mg-btm-sm text-input" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm password') }}">

            <button type="submit" class="button-base primary full-width mg-btm-lg">
                {{ __('Reset Password') }}
            </button>
        </form>
    </div>
</div>
@endsection
