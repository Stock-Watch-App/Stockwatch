<nav id="menu" role="navigation" v-touch:swipe.left="swipeHandler" class="sidebar-nav" v-bind:class="[isActive ? 'open' : 'closed']">
    @auth
        <div class="profile-wrap">
            <!-- <img src="{{ asset('/storage/avatar-default.svg') }}" title="Profile image" height="25px" width="25px" class="profile-pic" /> -->
            <!-- <avatar :user="{{ auth()->user() }}" height="25" width="25" class="profile-pic"></avatar> -->
            <div class="profile-name">
                <span>{{ Auth::user()->name }}</span>
            </div>
        </div>
    @endauth
    <ul class="sidebar-nav-list">
        <li class="collapse-btn-wrap">
            <button class="button-base icon toggle" @click="toggleNavbar()" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                <figure>
                    <font-awesome-icon :icon="['fad', isActive ? 'arrow-to-left' : 'arrow-to-right']" fixed-width></font-awesome-icon></figure><span v-show="isActive">Collapse Panel</span>
            </button>
        </li>
        @if(Auth::check() && Auth::user()->hasVerifiedEmail())
            <li>
                <a href="/dashboard" title="Dashboard" class="item-wrap">
                    <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                    <figure>
                        <font-awesome-icon :icon="['fad', 'chart-network']" fixed-width/>
                    </figure>
                    <span v-show="isActive">Dashboard</span>
                </a>
            </li>
        @endif
        @if(in_array(\App\Models\Season::current()->status, ['open','closed']))
            <li>
                <a href="/trades" title="Trades" class="item-wrap">
                    <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                    <figure>
                        <font-awesome-icon :icon="['fad', 'chart-line']" fixed-width/>
                    </figure>
                    @if(Auth::check() && Auth::user()->hasVerifiedEmail() && Auth::user()->isPlaying())
                        <span v-show="isActive">Trade</span>
                    @else
                        <span v-show="isActive">Stocks</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="/projections" title="Projections" class="item-wrap">
                    <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                    <figure>
                        <font-awesome-icon :icon="['fas', 'eye']" fixed-width/>
                    </figure>
                    <span v-show="isActive">Projections</span> </a>
            </li>
        @endif
        @if(in_array(\App\Models\Season::current()->status, ['open','closed']))
            <li>
                <a href="{{ route('leaderboard', ['season' => \App\Models\Season::current()->short_name]) }}" title="Leaderboard" class="item-wrap">
                    <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                    <figure>
                        <font-awesome-icon :icon="['fas', 'trophy']" fixed-width/>
                    </figure>
                    <span v-show="isActive">{{ strtoupper(\App\Models\Season::current()->short_name) }} Leaderboard</span>
                </a>
            </li>
        @endif
        @auth
            <li class="last-item">
                <a href="/account" title="Account" class="item-wrap">
                    <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                    <figure>
                        <font-awesome-icon :icon="['fas', 'user-circle']" fixed-width/>
                    </figure>
                    <span v-show="isActive">Account</span> </a>
            </li>
        @endauth

        <li class="last-item">
            <a href="/leaderboard" title="All-Time Leaderboard" class="item-wrap">
                <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                <figure>
                    <font-awesome-icon :icon="['fad', 'trophy-alt']" fixed-width/>
                </figure>
                <span v-show="isActive">All-Time Leaderboard</span> </a>
        </li>
        @auth
            @if(!\Auth::user()->permissions->isEmpty() || !\Auth::user()->roles->isEmpty())
                <li>
                    <a href="/admin" title="Admin" class="item-wrap">
                        <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                        <figure>
                            <font-awesome-icon icon="user-shield" fixed-width/>
                        </figure>
                        <span v-show="isActive">Admin</span> </a>
                </li>
            @endif
        @endauth
        <li>
            <a href="/faq" title="Frequently Asked Questions" class="item-wrap">
                <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                <figure>
                    <font-awesome-icon icon="info-circle" fixed-width/>
                </figure>
                <span v-show="isActive">FAQ</span> </a>
        </li>

        @guest
            <li>
                <a class="item-wrap" title="Login" href="{{ route('login') }}">
                    <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                    <figure>
                        <font-awesome-icon icon="sign-in" fixed-width/>
                    </figure>
                    <span v-show="isActive">{{ __('Login') }}</span>
                </a>
            </li>
        @endguest
        @auth
            <li>
                <a href="{{ env('FEEDBACK_URL') }}" title="Bug Reports" class="item-wrap">
                    <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                    <figure>
                        <font-awesome-icon icon="bug" fixed-width/>
                    </figure>
                    <span v-show="isActive">Report a Bug</span> </a>
            </li>
            <li>
                <a class="item-wrap" title="Logout" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <x-skeleton style="width:22px;height:22px;border-radius:50%;" />
                    <figure>
                        <font-awesome-icon icon="sign-out" fixed-width/>
                    </figure>
                    <span v-show="isActive">{{ __('Logout') }}</span> </a>

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
                    <span v-show="isActive">Social</span>
                    <font-awesome-icon class="chevron-icon" icon="chevron-down" fixed-width/>
                </div>
            </summary>
            <ul class="sidebar-nav-list">
                <li>
                    <a href="https://robhasawebsite.com/shows/big-brother-podcast-rhap/" title="Rob Has a Podcast" class="item-wrap" target="_blank" rel="noreferrer noopener">
                        <figure>
                            <font-awesome-icon icon="microphone" fixed-width/>
                        </figure>
                        <span v-show="isActive">Podcasts</span> </a>
                </li>
                <li>
                    <a href="https://www.twitch.tv/taranarmstrong/" title="Taran's Twitch Stream" class="item-wrap" target="_blank" rel="noreferrer noopener">
                        <figure>
                            <font-awesome-icon :icon="['fab', 'twitch']" fixed-width/>
                        </figure>
                        <span v-show="isActive">Twitch</span> </a>
                </li>
                <li>
                    <a href="https://twitter.com/ArmstrongTaran" title="Taran on Twitter" class="item-wrap" target="_blank" rel="noreferrer noopener">
                        <figure>
                            <font-awesome-icon :icon="['fab', 'twitter']" fixed-width/>
                        </figure>
                        <span v-show="isActive">Twitter</span> </a>
                </li>
            </ul>
        </details>
    </div>
</nav>
