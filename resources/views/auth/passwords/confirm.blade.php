@extends('layouts.landing')

@section('content')
<div class="landingWrapSingle mg-top-lg" id="landing">
    <div class="card single light">
        <h2 class="mg-btm-lg">{{ __('Confirm Password') }}</h2>
        <p>{{ __('Please confirm your password before continuing.') }}</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <label for="password" class="label label-hidden">{{ __('Password') }}</label>
            <input id="password" type="password" class="mg-btm-sm text-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Current password') }}">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <button type="submit" class="button-base primary full-width mg-btm-lg">
                {{ __('Confirm password') }}
            </button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </form>
    </div>
</div>
@endsection
