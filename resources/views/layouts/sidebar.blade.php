<nav id="menu" role="navigation" class="sidebar-nav" v-bind:class="[isActive ? 'open' : 'closed']">
    @auth
        <div class="profile-wrap">
            <!-- turn back on when profile pics work -->
        <!-- <img src="{{ asset('/storage/avatar-default.svg') }}" title="Profile image" class="profile-pic" /> -->
            <div class="profile-name">
                <span>{{ Auth::user()->name }}</span>
            </div>
        </div>
    @endauth

    <ul class="sidebar-nav-list">
        @if(Auth::check() && Auth::user()->hasVerifiedEmail())
            <li>
                <a href="/dashboard" title="Dashboard" class="item-wrap">
                    <figure>
                        <font-awesome-icon :icon="['fad', 'chart-network']" fixed-width/>
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Dashboard</span> </a>
            </li>
        @endif
        @if(in_array(\App\Models\Season::current()->status, ['open','closed']))
            <li>
                <a href="/trades" title="Trades" class="item-wrap">
                    <figure>
                        <font-awesome-icon :icon="['fad', 'chart-line']" fixed-width/>
                    </figure>
                    @if(Auth::check() && Auth::user()->hasVerifiedEmail())
                        <span v-bind:class="[isActive ? 'full' : 'mini']">Trade</span>
                    @else
                        <span v-bind:class="[isActive ? 'full' : 'mini']">Stocks</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="/projections" title="Projections" class="item-wrap">
                    <figure>
                        <font-awesome-icon :icon="['fas', 'eye']" fixed-width/>
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Projections</span> </a>
            </li>
        @endif
        @if(in_array(\App\Models\Season::current()->status, ['open','closed']))
            <li>
                <a href="{{ route('leaderboard', ['season' => \App\Models\Season::current()->short_name]) }}" title="Leaderboard" class="item-wrap">
                    <figure>
                        <font-awesome-icon :icon="['fas', 'trophy']" fixed-width/>
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">{{ \App\Models\Season::current()->short_name }} Leaderboard</span>
                </a>
            </li>
        @endif
        @auth
            <li class="last-item">
                <a href="/account" title="Account" class="item-wrap">
                    <figure>
                        <font-awesome-icon :icon="['fas', 'user-circle']" fixed-width/>
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Account</span> </a>
            </li>
        @endauth

        <li class="last-item">
            <a href="/leaderboard" title="All-Time Leaderboard" class="item-wrap">
                <figure>
                    <font-awesome-icon :icon="['fad', 'trophy-alt']" fixed-width/>
                </figure>
                <span v-bind:class="[isActive ? 'full' : 'mini']">All-Time Leaderboard</span> </a>
        </li>
        @auth
            @if(!\Auth::user()->permissions->isEmpty() || !\Auth::user()->roles->isEmpty())
                <li>
                    <a href="/admin" title="Admin" class="item-wrap">
                        <figure>
                            <font-awesome-icon icon="user-shield" fixed-width/>
                        </figure>
                        <span v-bind:class="[isActive ? 'full' : 'mini']">Admin</span> </a>
                </li>
            @endif
        @endauth
        <li>
            <a href="/faq" title="Frequently Asked Questions" class="item-wrap">
                <figure>
                    <font-awesome-icon icon="info-circle" fixed-width/>
                </figure>
                <span v-bind:class="[isActive ? 'full' : 'mini']">FAQ</span> </a>
        </li>

        @guest
            <li>
                <a class="item-wrap" title="Login" href="{{ route('login') }}">
                    <figure>
                        <font-awesome-icon icon="sign-in" fixed-width/>
                    </figure>
                    {{ __('Login') }}
                </a>
            </li>
        @endguest
        @auth
            <li>
                <a href="{{ env('FEEDBACK_URL') }}" title="Bug Reports" class="item-wrap">
                    <figure>
                        <font-awesome-icon icon="bug" fixed-width/>
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Report a Bug</span> </a>
            </li>
            <li>
                <a class="item-wrap" title="Logout" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <figure>
                        <font-awesome-icon icon="sign-out" fixed-width/>
                    </figure>
                    <span v-bind:class="[isActive ? 'full' : 'mini']">{{ __('Logout') }}</span> </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endauth
    </ul>
    <div class="native-collapse-wrap sidebar-collapse mg-btm-md">
        <details>
            <summary>
                <div class="chevron">
                    <span v-bind:class="[isActive ? 'full' : 'mini']">Social</span>
                    <font-awesome-icon class="chevron-icon" icon="chevron-down" fixed-width/>
                </div>
            </summary>
            <ul class="sidebar-nav-list">
                <li>
                    <a href="https://robhasawebsite.com/shows/big-brother-podcast-rhap/big-brother-canada-big-brother/" title="Rob Has a Podcast" class="item-wrap" target="_blank" rel="noreferrer noopener">
                        <figure>
                            <font-awesome-icon icon="microphone" fixed-width/>
                        </figure>
                        <span v-bind:class="[isActive ? 'full' : 'mini']">Podcasts</span> </a>
                </li>
                <li>
                    <a href="https://www.twitch.tv/taranarmstrong/" title="Taran's Twitch Stream" class="item-wrap" target="_blank" rel="noreferrer noopener">
                        <figure>
                            <font-awesome-icon :icon="['fab', 'twitch']" fixed-width/>
                        </figure>
                        <span v-bind:class="[isActive ? 'full' : 'mini']">Twitch</span> </a>
                </li>
                <li>
                    <a href="https://twitter.com/ArmstrongTaran" title="Taran on Twitter" class="item-wrap" target="_blank" rel="noreferrer noopener">
                        <figure>
                            <font-awesome-icon :icon="['fab', 'twitter']" fixed-width/>
                        </figure>
                        <span v-bind:class="[isActive ? 'full' : 'mini']">Twitter</span> </a>
                </li>
            </ul>
        </details>
    </div>
</nav>
