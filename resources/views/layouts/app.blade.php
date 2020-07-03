<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Stock Watch') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="app-wrapper">
    <!-- <flash-message class="myCustomClass"></flash-message> -->
    <aside>
        <button class="button-base toggle" @click="toggleNavbar()" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <font-awesome-icon icon="bars" size="lg"/>
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
                </p>
                </form>
            </div>
        @endif
        @yield('content')
    </main>
    <footer class="footer">
        <ul>
            <li>
                <a href="/tos" title="Terms of Service"> Terms of Service </a>
            </li>
            <li>
                <a href="/privacy" title="Privacy Policy"> Privacy Policy </a>
            </li>
            <li>
                <a href="mailto:hello@realitystockwatch.com" title="Email StockWatch"> hello@realitystockwatch.com </a>
            </li>
        </ul>

        <p>&copy; {{ date('Y') }} Reality Stock Watch. All Rights Reserved.</p>
    </footer>
</div>
@include('fathom')
</body>
</html>
