@extends('layouts.landing')

@section('content')
<div class="landingWrap textCenter mg-top-lg" id="landing">
    <h1>Register for the Big Brother Canada 8 Stock Watch!</h1>
    <div class="card dark">
        <a class="button-base twitter icon mg-btm-sm" href="/login/twitter" alt="Sign in with Twitter">
            <figure>
                <font-awesome-icon :icon="['fab', 'twitter']" size="lg"/>
            </figure>
            <span>Sign-in with Twitter</span>
        </a>
        <a class="button-base discord icon mg-btm-sm" href="/login/discord" alt="Sign in with Discord">
            <figure>
                <font-awesome-icon :icon="['fab', 'discord']" size="lg"/>
            </figure>
            <span>Sign-in with Discord</span>
        </a>
        <a class="button-base facebook icon mg-btm-sm" href="/login/facebook" alt="Sign in with Facebook">
            <figure>
                <font-awesome-icon :icon="['fab', 'facebook']" size="lg"/>
            </figure>
            <span>Sign-in with Facebook</span>
        </a>
        <a class="button-base twitch icon" href="/login/twitch" alt="Sign in with Twich">
            <figure>
                <font-awesome-icon :icon="['fab', 'twitch']" size="lg"/>
            </figure>
            <span>Sign-in with Twitch</span>
        </a>
    </div>
</div>
@endsection