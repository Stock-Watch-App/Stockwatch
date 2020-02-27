@extends('layouts.app')

@section('content')

    <h1>Hello</h1>
    <h2>Hello</h2>
    <h3>Hello</h3>
    <h4>Hello</h4>
    <h5>Hello</h5>
    <h6>Hello</h6>
    <p>Hellooooo</p>

    <button type="submit" class="button-base primary mg-top-lg mg-btm-lg">
        {{ __('Save changes') }}
    </button>

    <button type="submit" class="button-base primary ghost mg-top-lg mg-btm-lg">
        {{ __('Save changes') }}
    </button>

    <button type="submit" class="button-base secondary mg-top-lg mg-btm-lg">
        {{ __('Save changes') }}
    </button>

    <button type="submit" class="button-base secondary ghost mg-top-lg mg-btm-lg">
        {{ __('Save changes') }}
    </button>


    <form method="POST" action="{{ route('register') }}">
    @csrf
        <label for="name" class="label">{{ __('Display Name') }}</label>
        <input id="name" type="text" class="mg-btm-md input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Full name') }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="username" class="label">{{ __('Username') }}</label>
        <input id="name" type="text" class="mg-btm-md input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Username') }}">
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <label for="email" class="label">{{ __('E-Mail Address') }}</label>
        <input disabled id="email" type="email" class="mg-btm-md input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror


        <button type="submit" class="button-base secondary mg-top-lg mg-btm-lg">
            {{ __('Save changes') }}
        </button>
    </form>

@endsection