@extends('layouts.landing')

<!-- also can't hit this blade -->
@section('content')
<div class="landingWrap textCenter mg-top-lg" id="landing">
    <h2 class="mg-btm-lg">{{ __('Verify Your Email Address') }}</h2>

        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="button-base primary full-width mg-btm-lg">{{ __('click here to request another') }}</button>.
        </form>
    </div>
</div>
@endsection
