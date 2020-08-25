@extends('layouts.app')

@section('content')
    <div class="user-account app-content-max">
        <h3 class="mg-btm-lg">Account Settings</h3>

{{--        <avatar-picker--}}
{{--            :user="{{$user}}"--}}
{{--        ></avatar-picker>--}}

        <div class="logout">
            Not {{ $user->name }}?
            <a class="item-wrap" title="Logout" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <div class="edit-profile">
            <form method="POST" action="{{ route('account.update') }}">
                @csrf
                    <label for="name" class="label">{{ _('Display Name') }}</label>
                    <input id="name" type="text" class="mg-btm-md input @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus placeholder="{{ __('Display Name') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <p class="bodySM bodyLight">Impersonation of another user may result in action being taken against your account</p>

{{--                    <label for="email" class="label">{{ __('E-Mail Address') }}</label>--}}
{{--                    <input disabled id="email" type="email" class="mg-btm-md input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">--}}
{{--                    @error('email')--}}
{{--                        <span class="invalid-feedback" role="alert">--}}
{{--                            <strong>{{ $user-> }}</strong>--}}
{{--                        </span>--}}
{{--                    @enderror--}}


                    <button type="submit" class="button-base secondary mg-top-lg mg-btm-lg">
                        {{ __('Save changes') }}
                    </button>
                </form>
</div>
    </div>
@endsection
<script>
    import AvatarPicker from "../js/components/images/AvatarPicker";
    export default {
        components: {AvatarPicker}
    }
</script>
