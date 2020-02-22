<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="app-wrapper">
        <aside>
            <button class="button-base toggle" @click="toggleNavbar()" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <font-awesome-icon icon="bars" size="lg" />
            </button>

            <a class="logo" href="{{ url('/') }}">
                {{ config('app.name', 'Stock Watch') }}
            </a>
        </aside>
        <header>
        </header>
        <!-- <slideout-nav></slideout-nav> -->
        <nav id="menu" class="sidebar-nav" v-bind:class="[isActive ? 'open' : 'closed']">

            <div class="profile-wrap">
                <img src="{{ asset('/storage/avatar-default.svg') }}" alt="Profile image" class="profile-pic" />
                <p>Hello, {{ Auth::user()->name }}</p>
            </div>

            <ul class="navbar-nav ml-auto">
            <li>
                <a href="/">Dashboard</a>
            </li>
            <li>
                <a href="/">Leaderboard</a>
            </li>
            <li>
                <a href="/">History</a>
            </li>
            <li>
                <a href="/">Account</a>
            </li>
            <li>
                <a href="/">Admin</a>
            </li>

            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </nav>
        <main id="panel" class="app-content">
            @yield('content')
        </main>
        <footer>feets</footer>
    </div>
</body>
</html>
