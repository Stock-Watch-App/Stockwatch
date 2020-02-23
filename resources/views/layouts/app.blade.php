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

            <a class="logo" v-bind:class="[isActive ? 'full' : 'mini']" href="{{ url('/') }}">
                {{ config('app.name', 'Stock Watch') }}
            </a>
        </aside>
        <header>
        </header>
        <!-- <slideout-nav></slideout-nav> -->
        <nav id="menu" role="navigation" class="sidebar-nav" v-bind:class="[isActive ? 'open' : 'closed']">
            @guest
                <p>need to fix this logged in check</p>
            @else
                <div class="profile-wrap">
                    <img src="{{ asset('/storage/avatar-default.svg') }}" alt="Profile image" class="profile-pic" />
                    <div class="profile-name">
                        <span>{{ Auth::user()->name }}</span>
                        <span>@RobotKatie</span>
                    </div>
                </div>
            @endguest

            <ul class="sidebar-nav-list">
            <li>
                <a href="/" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="columns" fixed-width />
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="award" fixed-width />
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Leaderboard</span>
                </a>
            </li>
            <li>
                <a href="/" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="history" fixed-width />
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">History</span>
                </a>
            </li>
            <li>
                <a href="/" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="user-circle" fixed-width />
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Account</span>
                </a>
            </li>
            <li>
                <a href="/" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="user-shield" fixed-width />
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Admin</span>
                </a>
            </li>
            @guest
                <li>
                    <a class="item-wrap" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li>
                        <a class="item-wrap" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li>
                    <a class="item-wrap" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <figure>
                    <font-awesome-icon icon="sign-out-alt" fixed-width />
                    </figure>
                        <span v-bind:class="[isActive ? 'full' : 'mini']">{{ __('Logout') }}</span>
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
