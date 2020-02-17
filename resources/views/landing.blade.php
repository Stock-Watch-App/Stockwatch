@extends('layouts.landing')

@section('content')
<div class="landingWrap textCenter" id="landing">
    <h1>Register for the Big Brother Canada 8 Stock Watch!</h1>
    <div class="card">
        <button><font-awesome-icon :icon="['fab', 'reddit']"/></button>
        <button><font-awesome-icon :icon="['fab', 'twitter']"/></button>
        <button><font-awesome-icon :icon="['fab', 'discord']"/></button>
        <button><font-awesome-icon :icon="['fab', 'facebook']"/></button>
        <button><font-awesome-icon :icon="['fab', 'twitch']"/></button>
    </div>
</div>
@endsection