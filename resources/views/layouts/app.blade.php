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
        @if(Auth::user()->id === 58)
            <div id="collision-banner" class="ohno flash__message">
                <p>
                    There has been an issue detected with this account. You may have experienced this as your
                    username changing or the wrong stocks being purchased. (If you have observed neither of
                    these effects and you think you may be seeing this message in error, you are welcome to
                    reach out to us at the email below for confirmation)
                </p>
                <p>
                    Unfortunately, correcting the issue will result in the complete loss of any data associated
                    with this account. To continue playing the Stockwatch, please sign in using a different social network.
                </p>
                <p>
                    Since the market is already closed for the week, if you email us us at
                    <a href="mailto:hello@realitystockwatch.com">hello@realitystockwatch.com</a> with both your new
                    username and the social network you signed in with, we will assign your account a credit to
                    compensate for the loss of stocks.
                </p>
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
