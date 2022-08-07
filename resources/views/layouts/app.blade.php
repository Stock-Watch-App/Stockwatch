<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Stock Watch') }}</title>
    @if(env('APP_ENV', 'production') === 'production')
        <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
    @else
        <link rel="icon" href="/favicon-dev.ico" type="image/x-icon"/>
    @endif
<!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @include('umami')
</head>
<body>
<div id="app" class="app-wrapper">
    <!-- <flash-message class="myCustomClass"></flash-message> -->
    <aside v-bind:class="[!isActive && !isMobile && 'mini']">
        <button v-bind:class="" id="mobile-collapse-btn" class="button-base icon" @click="toggleNavbar()" aria-controls="navbarSupportedContent" :aria-expanded="[isActive ? 'true' : 'false']" aria-label="{{ __('Open navigation menu') }}">
            <x-skeleton style="width:14px;height:14px;" />
            <font-awesome-icon :icon="['fas', 'bars']" />
        </button>

        <a class="logo" v-bind:class="[isActive ? 'full' : 'mini']" href="{{ url('/') }}">
            @include('logo')
        </a>
    </aside>

    @include('layouts.sidebar')

    <main id="panel" class="app-content">
        @if(Auth::check() && !Auth::user()->hasVerifiedEmail())
            <div id="collision-banner" class="info flash__message">
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                <p>
                    Please click the link we have sent you to verify your account.
                    <button type="submit" class="btn-link">Click here to request another email</button>.
                    If you signed in with a Social Account, please log out and sign in again.
                </p>
                </form>
            </div>
        @endif
        @yield('content')
    </main>
    <div class="ad">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3010710749489779"
     crossorigin="anonymous"></script>
        <!-- Reality stock watch -->
        <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-3010710749489779"
            data-ad-slot="9270090320"
            data-ad-format="auto"
            data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <footer class="footer">
        <ul>
            <li>
                <a href="/tos" title="Terms of Service"> Terms of Service </a>
            </li>
            <li>
                <a href="/privacy" title="Privacy Policy"> Privacy Policy </a>
            </li>
        </ul>

        <p>&copy; {{ date('Y') }} Reality Stock Watch. All Rights Reserved.</p>
    </footer>
</div>
</body>
</html>
