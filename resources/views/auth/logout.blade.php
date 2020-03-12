<a class="item-wrap" title="Logout" href="{{ route('logout') }}"
   onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
    <figure>
        <font-awesome-icon icon="sign-out-alt" fixed-width/>
    </figure>
    <span v-bind:class="[isActive ? 'full' : 'mini']">{{ __('Logout') }}</span> </a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
