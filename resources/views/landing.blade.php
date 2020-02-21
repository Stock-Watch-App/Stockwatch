@extends('layouts.landing')

@section('content')
<div class="landingWrap mg-top-lg" id="landing">
    @component('loginflow')
        <h2 class="mg-btm-lg">Create your account</h2>
        @component('sso')
        @endcomponent
        <div class="bottom-links">
            <a href="/register" alt="Register with email">Or register with email</a>
            <a href="/login" alt="Sign in">Sign in</a>
        </div>
    @endcomponent
</div>
@endsection
